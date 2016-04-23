<?php

namespace common\models;

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
class Order extends ActiveRecord {

    const STATUS_WAIT_SUBMIT = -1;  // 待提交，默认状态
    const STATUS_WAIT_PAYMENT = 0;  // 待支付
    const STATUS_WAIT_ACCEPT = 1;   // 待接单
    const STATUS_WAIT_SEND = 2;     // 待发货
    const STATUS_WAIT_ARRIVE = 3;   // 待送达
    const STATUS_WAIT_CONFIRM = 4;  // 待确认
    const STATUS_FINISHED = 5;      // 已完成

    const PAYMENT_ONLINE = 1;
    const PAYMENT_OFFLINE = 0;

    private static $_payMethodtList;
    private static $_statusList;

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
            'user_id' => '用户 ID',
            'business_id' => '商铺 ID',
            'device_id' => '设备 ID',
            'device_type' => '设备类型',
            'status' => '订单状态',
            'origin_price' => '原价',
            'discount_price' => '优惠价',
            'total_price' => '总价',
            'consignee' => '顾客姓名',
            'phone' => '顾客电话',
            'address' => '顾客地址',
            'pay_method' => '支付方式',
            'remark' => '备注',
            'order_num' => '订单号',
            'booked_at' => '预订时间',
            'created_at' => '下单时间',
        ];
    }

    public static function getPayMethodList() {
        if (self::$_payMethodtList === null) {
            self::$_payMethodtList = [
                self::PAYMENT_ONLINE => '在线支付',
                self::PAYMENT_OFFLINE => '货到付款'
            ];
        }

        return self::$_payMethodtList;
    }

    public static function getStatusList() {
        if (self::$_statusList === null) {
            self::$_statusList = [
                self::STATUS_WAIT_ACCEPT => '待接单',
                self::STATUS_WAIT_SEND => '待配送',
                self::STATUS_FINISHED => '已完成',
            ];
        }

        return self::$_statusList;
    }

//    public function getBusiness_info() {
//        return $this->hasOne(Business::className(), ['id' => 'business_id']);
//    }
//
//    public function getBought_product_list() {
//        return OrderProduct::find()->where(['order_id' => $this->id])->all();
//    }
//
//    public function getExtra_fee_list() {
//        return OrderExtra::find()->where(['order_id' => $this->id])->all();
//    }
//
//    public function getDiscount_info_list() {
//        return OrderDiscount::find()->where(['order_id' => $this->id])->all();
//    }
}