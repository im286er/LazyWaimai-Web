<?php

namespace restapi\modules\v1\discount;

use restapi\modules\v1\models\Order;
use restapi\modules\v1\beans\DiscountInfo;
use restapi\modules\v1\beans\SettleBody;
use restapi\modules\v1\beans\DiscountResult;

/**
 * 满减优惠的逻辑处理类
 */
class FullCutDiscount implements IDiscount {

    /**
     * 处理活动优惠，返回优惠结果
     * @param DiscountInfo $discountInfo
     * @param SettleBody $settleBody
     * @return DiscountResult $discountResult
     */
    public function handleDiscount($discountInfo, $settleBody) {
        $discountResult = new DiscountResult();

        if ($settleBody->payMethod == Order::PAYMENT_ONLINE) {
            $attributes = json_decode($discountInfo->attribute);
            foreach ($attributes as $attribute) {
                if ($settleBody->originPrice > $attribute->condition
                    && $discountResult->discountPrice < $attribute->cut_price) {
                    $discountResult->discountPrice = $attribute->cut_price;
                    $discountResult->isValid = true;
                    $discountResult->isShare = $discountInfo->isShare;
                    $discountResult->description = '在线支付满' . $attribute->condition . '减' . $attribute->cut_price;
                }
            }
        }

        return $discountResult;
    }
}