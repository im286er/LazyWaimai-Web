<?php

namespace restapi\modules\v1\discount;

use restapi\modules\v1\beans\DiscountInfo;
use restapi\modules\v1\beans\SettleBody;
use restapi\modules\v1\beans\SettleResult;
use restapi\modules\v1\beans\DiscountResult;

interface IDiscount {

    /**
     * 处理活动优惠，返回优惠结果
     * @param DiscountInfo $discountInfo
     * @param SettleBody $settleBody
     * @return DiscountResult $discountResult
     */
    function handleDiscount($discountInfo, $settleBody);
}