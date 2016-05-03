<?php

namespace restapi\discount;

use restapi\beans\DiscountInfo;
use restapi\beans\SettleBody;
use restapi\beans\DiscountResult;

interface IDiscount {

    /**
     * 处理活动优惠，返回优惠结果
     * @param DiscountInfo $discountInfo
     * @param SettleBody $settleBody
     * @return DiscountResult $discountResult
     */
    function handleDiscount($discountInfo, $settleBody);
}