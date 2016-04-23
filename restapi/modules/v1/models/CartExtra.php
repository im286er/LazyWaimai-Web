<?php

namespace restapi\modules\v1\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%cart_extra}}".
 *
 * @property integer $id
 * @property integer $cart_id
 * @property string $name
 * @property string $description
 * @property double $price
 * @property integer $created_at
 * @property integer $updated_at
 */
class CartExtra extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%cart_extra}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['cart_id', 'name', 'price', 'created_at', 'updated_at'], 'required'],
            [['cart_id', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => '主键ID',
            'cart_id' => '购物车ID',
            'name' => '名称',
            'description' => '描述',
            'price' => '价格',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 处理购物车里额外费用
     * @param SettleBody $settleBody
     * @return CartExtra[]
     */
    public static function handleCartExtraFee($settleBody) {
        /** @var $businessInfo Business */
        $businessInfo = Business::findOne($settleBody->businessId);
        $cartExtraList = [];
        if ($businessInfo->shipping_fee > 0) {
            $shippingFee = new CartExtra();
            $shippingFee->name = '配送费';
            $shippingFee->description = '本订单由【'.$businessInfo->name.'】进行配送';
            $shippingFee->price = $businessInfo->shipping_fee;

            array_push($cartExtraList, $shippingFee);
        }
        if ($businessInfo->package_fee > 0) {
            $packageFee = new CartExtra();
            $packageFee->name = '包装费';
            $packageFee->price = $businessInfo->package_fee;

            array_push($cartExtraList, $packageFee);
        }

        return $cartExtraList;
    }
}