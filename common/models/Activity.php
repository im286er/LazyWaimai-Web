<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "activity".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $icon_name
 * @property string $icon_color
 * @property string $code
 * @property integer $is_share
 * @property integer $priority
 * @property integer $created_at
 * @property integer $updated_at
 */
class Activity extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%activity}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'description', 'icon_name', 'icon_color', 'code', 'is_share', 'priority'], 'required'],
            [['is_share', 'priority', 'created_at', 'updated_at'], 'integer'],
            [['name', 'code'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 100],
            [['icon_name', 'icon_color'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'icon_name' => 'Icon Name',
            'icon_color' => 'Icon Color',
            'code' => 'Code',
            'is_share' => 'Is Share',
            'priority' => 'Priority',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
