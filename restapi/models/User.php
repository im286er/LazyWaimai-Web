<?php

namespace restapi\models;

use Yii;
use yii\db\ActiveRecord;
use common\helpers\Validator;
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
            [['user_phone', 'user_pwd'], 'required'],
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

    /**
     * @inheritdoc
     */
    public function fields() {
        $fields = parent::fields();
        unset($fields['user_pwd']);

        return $fields;
    }

    /**
     * 根据帐号查询该用户的信息
     * @param $account string 用户的账户,可以是手机号 用户名和邮箱
     * @return null|User
     */
    public static function findByAccount($account) {
        $condition = [];
        if (Validator::isMobile($account)) {
            $condition['user_phone'] = $account;
        } else if (Validator::isEmail($account)) {
            $condition['user_email'] = $account;
        } else {
            $condition['user_name'] = $account;
        }

        return User::findOne($condition);
    }

    /////////////////////////////////////
    ///          IdentityInterface     //
    /////////////////////////////////////
    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        $tokenInfo = Token::findByToken($token);
        if ($tokenInfo !== null) {
            return static::findOne($tokenInfo['user_id']);
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {}

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {}
}
