<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $user_name
 * @property string $user_phone
 * @property string $user_pwd
 * @property string $user_email
 * @property string $avatar_url
 * @property integer $last_address_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends ActiveRecord implements IdentityInterface {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_phone', 'user_pwd', 'created_at', 'updated_at'], 'required'],
            [['last_address_id', 'created_at', 'updated_at'], 'integer'],
            [['user_name', 'user_pwd', 'user_email'], 'string', 'max' => 50],
            [['user_phone'], 'string', 'max' => 20],
            [['avatar_url'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_name' => 'User Name',
            'user_phone' => 'User Phone',
            'user_pwd' => 'User Pwd',
            'user_email' => 'User Email',
            'avatar_url' => 'Avatar Url',
            'last_address_id' => 'Last Address ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /////////////////////////////////////
    ///          IdentityInterface     //
    /////////////////////////////////////

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        $tokenInfo = Token::findByToken($token);
        if ($tokenInfo !== null) {
            return static::findOne($tokenInfo['user_id']);
        }

        return null;
    }

    public function getId() {
        return $this->id;
    }

    public function getAuthKey() {}

    public function validateAuthKey($authKey) {}
}
