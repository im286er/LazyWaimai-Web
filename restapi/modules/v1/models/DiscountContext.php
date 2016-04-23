<?php

namespace restapi\modules\v1\models;

/**
 * 优惠的代理类
 * Class DiscountContext
 * @package app\components\discount
 */
class DiscountContext {

    const FULL_CUT = "FULL_CUT";
    const FIRST_ORDER = 'FIRST_ORDER';

    private $discountManager;

    public function __construct($code) {
        switch ($code) {
            case self::FULL_CUT:
                $this->discountManager = new FullCutDiscount();
                break;
            case self::FIRST_ORDER:
                $this->discountManager = new FirstOrderDiscount();
                break;
        }
    }

    /**
     * 处理活动优惠的代理方法
     * @param DiscountInfo $discountInfo
     * @param SettleBody $settleBody
     * @param SettleResult $settleResult
     * @return DiscountResult $discountResult
     */
    public function handleDiscount($discountInfo, $settleBody, $settleResult) {
        return $this->discountManager->handleDiscount($discountInfo, $settleBody, $settleResult);
    }
}