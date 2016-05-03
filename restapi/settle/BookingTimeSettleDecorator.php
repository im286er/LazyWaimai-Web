<?php

namespace restapi\settle;

use yii;
use yii\web\BadRequestHttpException;
use restapi\beans\SettleBody;
use restapi\beans\SettleResult;
use restapi\modules\v1\models\Business;

class BookingTimeSettleDecorator extends SettleDecorator {

    /**
     * @param SettleBody $settleBody
     * @param SettleResult $settleResult
     * @throws BadRequestHttpException
     */
    public function settleBefore($settleBody, $settleResult) {
        // 可预订的时间段
        /** @var $businessInfo Business */
        $businessInfo = Business::findOne($settleBody->businessId);
        if ($businessInfo == null) {
            throw new BadRequestHttpException('不存在该商铺');
        }
        $bookingTimeList = [];
        $bookingTimeArr = explode(',', $businessInfo->booking_times);
        foreach ($bookingTimeArr as $bookingTime) {
            array_push($bookingTimeList, [
                'unix_time' => time(),
                'view_time' => $bookingTime,
                'send_time_tip' => '',
            ]);
        }
        // 默认添加一个立即送达的预订时间
        array_unshift($bookingTimeList, [
            'unix_time' => 0,
            'view_time' => '立即送出',
            'send_time_tip' => '',
        ]);
        $settleResult->booking_time_list = $bookingTimeList;
    }

    /**
     * @param SettleBody $settleBody
     * @param SettleResult $settleResult
     */
    public function settleAfter($settleBody, $settleResult) {}
}