<?php

namespace restapi\modules\v1\discount;

use yii;
use restapi\modules\v1\models\Order;
use restapi\modules\v1\beans\DiscountInfo;
use restapi\modules\v1\beans\SettleBody;
use restapi\modules\v1\beans\DiscountResult;

/**
 * 首单优惠的逻辑处理类
 */
class FirstOrderDiscount implements IDiscount {

    /**
     * 处理活动优惠，返回优惠结果
     * @param DiscountInfo $discountInfo
     * @param SettleBody $settleBody
     * @return DiscountResult $discountResult
     */
    public function handleDiscount($discountInfo, $settleBody) {
        // 查询该用户的有效订单数
        $count = Order::find()->where([
            'and',
            ['user_id' => Yii::$app->user->id],
            ['>', 'status', Order::STATUS_WAIT_SUBMIT]
        ])->count();

        $discountResult = new DiscountResult();
        $discountResult->isShare = $count == 0;
        $discountResult->isShare = $discountInfo->isShare;
        $discountResult->discountPrice = $discountInfo->attribute;
        $discountResult->description = '(不与其他活动共享)新用户下单立减'
            .$discountResult->discountPrice.'元';

        return $discountResult;
    }
}