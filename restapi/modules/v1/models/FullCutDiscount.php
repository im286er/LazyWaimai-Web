<?php

namespace restapi\modules\v1\models;

/**
 * 满减优惠的逻辑处理类
 */
class FullCutDiscount implements IDiscount {

    /**
     * 处理活动优惠，返回优惠结果
     * @param DiscountInfo $discountInfo
     * @param SettleBody $settleBody
     * @param SettleResult $settleResult
     * @return DiscountResult $discountResult
     */
    public function handleDiscount($discountInfo, $settleBody, $settleResult) {
        $discountResult = new DiscountResult();

        if ($settleBody->getPayMethod() == Order::PAYMENT_ONLINE) {
            $attributes = json_decode($discountInfo->getAttribute());
            foreach ($attributes as $condition => $cutPrice) {
                if ($settleResult->originPrice > $condition
                    && $discountResult->getDiscountPrice() < $cutPrice) {
                    $discountResult->setDiscountPrice($cutPrice);
                    $discountResult->setIsValid(true);
                    $discountResult->setIsShare($discountInfo->getIsShare());
                    $discountResult->setDescription('在线支付满' . $condition . '减' . $cutPrice);
                }
            }
        }

        return $discountResult;
    }
}