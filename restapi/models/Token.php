<?php

namespace restapi\models;

use Yii;
use yii\db\ActiveRecord;
use common\helpers\Constants;
use yii\behaviors\TimestampBehavior;
use yii\web\UnauthorizedHttpException;

/**
 * This is the model class for table "token".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $access_token
 * @property string $device_id
 * @property integer $valid_second
 * @property integer $created_at
 * @property integer $updated_at
 */
class Token extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%token}}';
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
            [['user_id', 'access_token', 'device_id', 'valid_second'], 'required'],
            [['user_id', 'valid_second', 'created_at', 'updated_at'], 'integer'],
            [['access_token', 'device_id'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeValidate() {
        if (parent::beforeValidate()) {
            $this->access_token = '#'.Yii::$app->security->generateRandomString(30);
            $this->device_id = Yii::$app->request->headers->get(Constants::HTTP_DEVICE_ID);
            $this->valid_second = Yii::$app->params[Constants::TOKEN_VALID_SECOND];

            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'access_token' => 'Access Token',
            'device_id' => 'Device ID',
            'valid_second' => 'Valid Second',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function validateIdentity($token, $deviceId) {
        $tokenInfo = Token::findOne(['access_token' => $token, 'device_id' => $deviceId]);
        if ($tokenInfo === null) {
            throw new UnauthorizedHttpException('Invalid token.');
        }

        $newCount = Token::find()->where(['user_id' => $tokenInfo['user_id']])
            ->andWhere(['>', 'created_at', $tokenInfo['created_at']])->count();
        if ($newCount > 0) {
            throw new UnauthorizedHttpException('Your account has been logged on another device.');
        }

        if (time() - $tokenInfo['created_at'] > $tokenInfo['valid_second']) {
            throw new UnauthorizedHttpException('Login status has expired, please log in again.');
        }

        return $tokenInfo;
    }

    public static function findByToken($token) {
        return static::findOne(['access_token' => $token]);
    }
}
