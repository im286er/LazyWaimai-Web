<?php

namespace restapi\modules\v1\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order".
 *
 * @property string $id
 * @property string $sign
 * @property string $user_id
 * @property string $business_id
 * @property string $device_id
 * @property string $device_type
 * @property integer $status
 * @property double $origin_price
 * @property double $discount_price
 * @property double $total_price
 * @property string $consignee
 * @property string $phone
 * @property string $address
 * @property integer $pay_method
 * @property string $remark
 * @property string $order_num
 * @property string $booked_at
 * @property integer $created_at
 */
class Order2 extends ActiveRecord {

    const STATUS_WAIT_SUBMIT = -1;  // 待提交，默认状态
    const STATUS_WAIT_PAYMENT = 0;  // 待支付
    const STATUS_WAIT_ACCEPT = 1;   // 待接单
    const STATUS_WAIT_SEND = 2;     // 待发货
    const STATUS_WAIT_ARRIVE = 3;   // 待送达
    const STATUS_WAIT_CONFIRM = 4;  // 待确认
    const STATUS_FINISHED = 5;      // 已完成

    const PAYMENT_ONLINE = 1;
    const PAYMENT_OFFLINE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%order}}';
    }

    public function extraFields() {
        return ['business_info', 'bought_product_list', 'extra_fee_list', 'discount_info_list'];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['sign', 'user_id', 'business_id', 'device_id', 'device_type', 'status', 'origin_price', 'discount_price', 'total_price', 'pay_method', 'order_num', 'created_at'], 'required'],
            [['user_id', 'business_id', 'status', 'pay_method', 'created_at'], 'integer'],
            [['origin_price', 'discount_price', 'total_price'], 'number'],
            [['sign', 'device_id', 'address'], 'string', 'max' => 100],
            [['device_type', 'consignee', 'phone', 'booked_at'], 'string', 'max' => 20],
            [['remark'], 'string', 'max' => 200],
            [['order_num'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'sign' => 'Sign',
            'user_id' => 'User ID',
            'business_id' => 'Business ID',
            'device_id' => 'Device ID',
            'device_type' => 'Device Type',
            'status' => 'Status',
            'origin_price' => 'Origin Price',
            'discount_price' => 'Discount Price',
            'total_price' => 'Total Price',
            'consignee' => 'Consignee',
            'phone' => 'Phone',
            'address' => 'Address',
            'pay_method' => 'Pay Method',
            'remark' => 'Remark',
            'order_num' => 'Order Num',
            'booked_at' => 'Booked At',
            'created_at' => 'Created At',
        ];
    }

    public function getBusiness_info() {
        return $this->hasOne(Business::className(), ['id' => 'business_id']);
    }

    public function getBought_product_list() {
        return OrderProduct::find()->where(['order_id' => $this->id])->all();
    }

    public function getExtra_fee_list() {
        return OrderExtra::find()->where(['order_id' => $this->id])->all();
    }

    public function getDiscount_info_list() {
        return OrderDiscount::find()->where(['order_id' => $this->id])->all();
    }
}
