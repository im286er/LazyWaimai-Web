<?php

namespace restapi\modules\v1\models;

interface IDiscount {

    /**
     * 处理活动优惠，返回优惠结果
     * @param DiscountInfo $discountInfo
     * @param SettleBody $settleBody
     * @param SettleResult $settleResult
     * @return DiscountResult $discountResult
     */
    function handleDiscount($discountInfo, $settleBody, $settleResult);
}