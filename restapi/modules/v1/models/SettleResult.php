<?php

namespace restapi\modules\v1\models;

use yii;
use yii\web\BadRequestHttpException;
use restapi\models\User;

/**
 * 结算的结果
 */
class SettleResult {
    /**
     * 最近使用的地址
     * @var Address
     * @SerializedName('last_address')
     */
    public $lastAddress;
    /**
     * 支付方式
     * @var integer
     * @SerializedName('pay_method')
     */
    public $payMethod;
    /**
     * 可预订的时间
     * @var string[]
     * @SerializedName('booking_time_list')
     */
    public $bookingTimeList;
//    /**
//     * @var Business
//     * @SerializedName('business_info')
//     */
//    public $businessInfo;
//    /**
//     * 原价
//     * @var double
//     * @SerializedName('origin_price')
//     */
//    public $originPrice;
//    /**
//     * 优惠的价格
//     * @var double
//     * @SerializedName('discount_price')
//     */
//    public $discountPrice;
//    /**
//     * 最终的价格
//     * @var double
//     * @SerializedName('total_price')
//     */
//    public $totalPrice;
//    /**
//     * 选购的商品列表
//     * @var BoughtProduct[]
//     * @SerializedName('bought_product_list')
//     */
//    public $boughtProductList = [];
//    /**
//     * 商家的额外费用列表
//     * @var ExtraFee[]
//     * @SerializedName('extra_fee_list')
//     */
//    public $extraFeeList = [];
//    /**
//     * 可用的优惠列表
//     * @var DiscountInfo[]
//     * @SerializedName('discount_info_list')
//     */
//    public $discountInfoList = [];
    /**
     * 能否提交
     * @var boolean
     * @SerializedName('can_submit')
     */
    public $canSubmit;

    ///////////////////////////////////////////////////
    ///                 必需的传参                    ///
    ///////////////////////////////////////////////////
    /**
     * @var SettleBody
     * @Exclude
     */
    private $settleBody;

    /**
     * 构造参数
     * @param $settleBody
     */
    public function __construct($settleBody) {
        $this->settleBody = $settleBody;

        // 最近一次使用的地址
        /** @var $userInfo User */
        $userInfo = User::findOne(Yii::$app->user->id);
        if ($userInfo->last_address_id != 0) {
            $this->lastAddress = Address::findOne($userInfo->last_address_id);
        }

        // 支付方式
        $this->payMethod = $this->settleBody->payMethod;

        // 可预订的时间段
        $this->handleBookingTime();

        // 处理购物车结算
        $this->handleCartInfo();

        // 计算最终商品总价
        $this->totalPrice = $this->originPrice - $this->discountPrice;
        $this->totalPrice = $this->totalPrice > 0 ? $this->totalPrice : 0;

        // 能否提交
        $this->canSubmit = ($this->lastAddress != null);
    }

    /**
     * 处理商家的可预订时间
     * @return $this
     * @throws BadRequestHttpException
     */
    private function handleBookingTime() {
        /** @var $businessInfo Business */
        $businessInfo = Business::findOne($this->settleBody->businessId);
        if ($businessInfo == null) {
            throw new BadRequestHttpException('不存在该商铺');
        }
        $bookingTimeArr = explode(',', $businessInfo->booking_times);
        foreach ($bookingTimeArr as $bookingTime) {
            array_push($this->bookingTimeList, [
                'unix_time' => time(),
                'view_time' => $bookingTime,
                'send_time_tip' => '',
            ]);
        }
        // 默认添加一个立即送达的预订时间
        array_unshift($this->bookingTimeList, [
            'unix_time' => 0,
            'view_time' => '立即送出',
            'send_time_tip' => '',
        ]);

        return $this;
    }

    /**
     * 处理购物车信息
     */
    private function handleCartInfo() {
        // 选购的商品信息
        $this->handleShoppingProduct();
        // 商家的额外费用
        $this->handleBusinessExtraFee();
        // 可用的商家优惠
        $this->handleBusinessDiscount();
    }

    /**
     * 处理选购的商品信息且计算出商品总价
     * @return $this
     */
    private function handleShoppingProduct() {
        $shoppingProductList = $this->settleBody->shoppingProductList;

        if ($shoppingProductList == null || count($shoppingProductList) == 0) {
            return $this;
        }

        foreach ($shoppingProductList as $shoppingProduct) {
            /** @var $product Product */
            $product = Product::findOne($shoppingProduct->getId());

            $boughtProduct = new BoughtProduct();
            $boughtProduct->setId($product->id);
            $boughtProduct->setName($product->name);
            $boughtProduct->setUnitPrice($product->price);
            $boughtProduct->setTotalPrice($product->price * $shoppingProduct->getQuantity());
            $boughtProduct->setCategoryId($product->category_id);
            $boughtProduct->setQuantity($shoppingProduct->getQuantity());
            $boughtProduct->setLeftNum($product->left_num);
            array_push($this->boughtProductList, $boughtProduct);

            // 累加结算的商品总价
            $this->originPrice += $boughtProduct->getTotalPrice();
        }

        return $this;
    }

    /**
     * 处理商家额外费用
     * @return $this
     * @throws BadRequestHttpException
     */
    private function handleBusinessExtraFee() {
        /** @var $businessInfo Business */
        $businessInfo = Business::findOne($this->settleBody->businessId);
        if ($businessInfo == null) {
            throw new BadRequestHttpException('不存在该商铺');
        }

        if ($businessInfo->shipping_fee > 0) {
            // 加价
            $this->originPrice += $businessInfo->shipping_fee;

            $shippingFee = new ExtraFee();
            $shippingFee->setName('配送费');
            $shippingFee->setDescription('本订单由【'.$businessInfo->name.'】进行配送');
            $shippingFee->setPrice($businessInfo->shipping_fee);

            array_push($this->extraFeeList, $shippingFee);
        }
        if ($businessInfo->package_fee > 0) {
            // 加价
            $this->originPrice += $businessInfo->package_fee;

            $packageFee = new ExtraFee();
            $packageFee->setName('包装费');
            $packageFee->setPrice($businessInfo->package_fee);

            array_push($this->extraFeeList, $packageFee);
        }

        return $this;
    }

    /**
     * 处理商家优惠
     * @return $this
     */
    private function handleBusinessDiscount() {
        $businessId = $this->settleBody->businessId;
        $discountInfoList = BusinessActivity::discountInfoList($businessId);

        foreach ($discountInfoList as &$discountInfo) {
            $discountContext = new DiscountContext($discountInfo->getCode());
            if ($discountContext != null) {
                $discountResult = $discountContext->handleDiscount($discountInfo, $this->settleBody, $this);
                // 设置优惠描述和优惠价格
                $discountInfo->setDescription($discountResult->getDescription());
                $discountInfo->setPrice($discountResult->getDiscountPrice());
                if ($discountResult->isIsValid()) {
                    if (!$discountResult->isIsShare()) {
                        $this->discountInfoList = [];
                        array_push($this->discountInfoList, $discountInfo);
                        break;
                    } else {
                        array_push($this->discountInfoList, $discountInfo);
                    }
                }
            }
        }

        return $this;
    }
}