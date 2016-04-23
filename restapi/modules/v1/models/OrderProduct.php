<?php

namespace restapi\modules\v1\models;

use Yii;

/**
 * This is the model class for table "{{%order_product}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property string $name
 * @property integer $quantity
 * @property double $unit_price
 * @property double $total_price
 * @property integer $created_at
 */
class OrderProduct extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'name', 'quantity', 'unit_price', 'total_price', 'created_at'], 'required'],
            [['order_id', 'product_id', 'quantity', 'created_at'], 'integer'],
            [['unit_price', 'total_price'], 'number'],
            [['name'], 'string', 'max' => 50],
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
            'product_id' => '商品ID',
            'name' => '商品名称',
            'quantity' => '商品数量',
            'unit_price' => '商品单价',
            'total_price' => '商品总价',
            'created_at' => '创建时间',
        ];
    }
}
