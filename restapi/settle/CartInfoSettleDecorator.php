<?php

namespace restapi\settle;

use yii;
use yii\web\BadRequestHttpException;
use restapi\modules\v1\models\Cart;
use restapi\beans\SettleBody;
use restapi\beans\SettleResult;

class CartInfoSettleDecorator extends SettleDecorator {

    /**
     * @param SettleBody $settleBody
     * @param SettleResult $settleResult
     * @throws BadRequestHttpException
     */
    public function settleBefore($settleBody, $settleResult) {
        // 计算最终价格
        $settleBody->totalPrice = $settleBody->originPrice - $settleBody->discountPrice;
        $settleBody->totalPrice = $settleBody->totalPrice > 0 ? $settleBody->totalPrice : 0;

        // 储存购物车信息到数据库
        $cartInfo = new Cart();
        $cartInfo->business_id = $settleBody->businessId;
        $cartInfo->last_address_id = $settleBody->lastAddressId;
        $cartInfo->pay_method = $settleBody->payMethod;
        $cartInfo->origin_price = $settleBody->originPrice;
        $cartInfo->discount_price = $settleBody->discountPrice;
        $cartInfo->total_price = $settleBody->totalPrice;
        if (!$cartInfo->save()) {
            throw new BadRequestHttpException('存储购物车信息错误.');
        }
        // 保存购物车ID到settleBody以便余下的操作利用
        $settleBody->cartId = $cartInfo->id;
        $settleResult->cart_info = $cartInfo;
    }

    /**
     * @param SettleBody $settleBody
     * @param SettleResult $settleResult
     */
    public function settleAfter($settleBody, $settleResult) {

    }
}