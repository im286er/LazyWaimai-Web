<?php

namespace restapi\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%order_discount}}".
 *
 * @property string $id
 * @property integer $order_id
 * @property integer $activity_id
 * @property string $name
 * @property double $price
 * @property string $description
 * @property string $icon_name
 * @property string $icon_color
 * @property integer $created_at
 */
class OrderDiscount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_discount}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'activity_id', 'name', 'price', 'description', 'icon_name', 'icon_color', 'created_at'], 'required'],
            [['order_id', 'activity_id', 'created_at'], 'integer'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
            [['icon_name', 'icon_color'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键ID',
            'order_id' => '订单ID',
            'activity_id' => '活动ID',
            'name' => '活动的名称',
            'price' => '优惠的价格',
            'description' => '活动的描述',
            'icon_name' => '活动图标的文字',
            'icon_color' => '活动图标的颜色',
            'created_at' => '创建时间',
        ];
    }
}
