<?php

namespace restapi\settle;

use yii;
use Exception;
use restapi\beans\SettleBody;
use restapi\beans\SettleResult;
use restapi\modules\v1\models\CartDiscount;
use restapi\modules\v1\models\BusinessActivity;
use restapi\discount\DiscountContext;

class DiscountSettleDecorator extends SettleDecorator {

    /**
     * @var CartDiscount[]
     */
    private $CartDiscounts;

    /**
     * @param SettleBody $settleBody
     * @param SettleResult $settleResult
     */
    public function settleBefore($settleBody, $settleResult) {
        $discountInfoList = BusinessActivity::discountInfoList($settleBody->businessId);
        foreach ($discountInfoList as $discountInfo) {
            $discountContext = new DiscountContext($discountInfo->code);
            if ($discountContext != null) {
                $discountResult = $discountContext->handleDiscount($discountInfo, $settleBody);

                if ($discountResult->isValid) {
                    $cartDiscount = new CartDiscount();
                    $cartDiscount->activity_id = $discountInfo->id;
                    $cartDiscount->name = $discountInfo->name;
                    $cartDiscount->price = $discountResult->discountPrice;
                    $cartDiscount->description = $discountResult->description;
                    $cartDiscount->icon_name = $discountInfo->iconName;
                    $cartDiscount->icon_color = $discountInfo->iconColor;

                    if (!$discountResult->isShare) {
                        $this->CartDiscounts = [];
                        $settleBody->discountPrice = $cartDiscount->price;
                        $this->CartDiscounts[] = $cartDiscount;
                        break;
                    } else {
                        $settleBody->discountPrice += $cartDiscount->price;
                        $this->CartDiscounts[] = $cartDiscount;
                    }
                }
            }
        }
    }

    /**
     * @param SettleBody $settleBody
     * @param SettleResult $settleResult
     */
    public function settleAfter($settleBody, $settleResult) {
        // 使用事务来进行保存
        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($this->CartDiscounts as $discountInfo) {
                /** @var $discountInfo CartDiscount */
                $discountInfo->cart_id = $settleBody->cartId;
                if (!$discountInfo->save()) {
                    throw new Exception('存储优惠信息出错.');
                }
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
        }
    }
}