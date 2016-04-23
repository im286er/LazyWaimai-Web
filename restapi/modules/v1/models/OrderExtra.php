<?php

namespace restapi\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%order_extra}}".
 *
 * @property string $id
 * @property integer $order_id
 * @property string $name
 * @property string $description
 * @property double $price
 * @property integer $created_at
 */
class OrderExtra extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_extra}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'name', 'price', 'created_at'], 'required'],
            [['order_id', 'created_at'], 'integer'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
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
            'name' => '名称',
            'description' => '描述',
            'price' => '价格',
            'created_at' => '创建时间',
        ];
    }
}
