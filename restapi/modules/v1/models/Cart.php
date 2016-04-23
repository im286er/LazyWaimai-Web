<?php

namespace restapi\modules\v1\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%cart}}".
 *
 * @property integer $id
 * @property integer $business_id
 * @property integer $last_address_id
 * @property string $pay_method
 * @property double $origin_price
 * @property double $discount_price
 * @property double $total_price
 * @property integer $created_at
 * @property integer $updated_at
 */
class Cart extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%cart}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['business_id', 'last_address_id', 'pay_method', 'origin_price', 'discount_price', 'total_price'], 'required'],
            [['business_id', 'last_address_id', 'created_at', 'updated_at'], 'integer'],
            [['pay_method'], 'string'],
            [['origin_price', 'discount_price', 'total_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => '购物车ID',
            'business_id' => '商铺ID',
            'last_address_id' => '地址ID',
            'pay_method' => '支付方式',
            'origin_price' => '原价',
            'discount_price' => '优惠价',
            'total_price' => '总价',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public function extraFields() {
        return ['last_address', 'business_info', 'shopping_product_list', 'extra_fee_list', 'discount_info_list'];
    }

    public function getLast_address() {
        return $this->hasOne(Address::className(), ['id' => 'last_address_id']);
    }

    public function getBusiness_info() {
        return $this->hasOne(Business::className(), ['id' => 'business_id']);
    }

    public function getShopping_product_list() {
        return CartProduct::find()->where(['cart_id' => $this->id])->all();
    }

    public function getExtra_fee_list() {
        return CartExtra::find()->where(['cart_id' => $this->id])->all();
    }

    public function getDiscount_info_list() {
        return CartDiscount::find()->where(['cart_id' => $this->id])->all();
    }
}