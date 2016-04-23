<?php

namespace restapi\modules\v1\models;

use yii;

/**
 * 首单优惠的逻辑处理类
 */
class FirstOrderDiscount implements IDiscount {

    /**
     * 处理活动优惠，返回优惠结果
     * @param DiscountInfo $discountInfo
     * @param SettleBody $settleBody
     * @param SettleResult $settleResult
     * @return DiscountResult $discountResult
     */
    public function handleDiscount($discountInfo, $settleBody, $settleResult) {
        // 查询该用户的有效订单数
        $count = Order::find()->where([
            'and',
            ['user_id' => Yii::$app->user->getId()],
            ['>', 'status', Order::STATUS_WAIT_SUBMIT]
        ])->count();

        $discountResult = new DiscountResult();
        $discountResult->setIsValid(boolval($count == 0));
        $discountResult->setIsShare(boolval($discountInfo->getIsShare()));
        $discountResult->setDiscountPrice((float)$discountInfo->getAttribute());
        $discountResult->setDescription('(不与其他活动共享)新用户下单立减'
            .$discountResult->getDiscountPrice().'元');

        return $discountResult;
    }
}