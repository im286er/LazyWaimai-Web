<?php
namespace restapi\modules\v1\models;

use Yii;
use yii\base\Model;
use restapi\models\User;
use common\helpers\Constants;

class LoginForm extends Model {

    public $account;
    public $password;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['account', 'required', 'message' => '账户不能为空.'],
            ['password', 'required', 'message' => '密码不能为空.'],
            [['account', 'password'], 'filter', 'filter' => 'trim'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'account' => '帐号',
            'password' => '密码',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                $this->addError($attribute, '不存在该帐号.');
            } else if (!$user->validatePassword($this->password)) {
                $this->addError($attribute, '密码输入错误.');
            }
        }
    }

    /**
     * login a user using the provided account(include email mobile username) and password.
     *
     * @return User|null the login's user or null if login fails
     */
    public function login() {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->last_ip = Yii::$app->request->userIP;
            $user->last_device_type = Yii::$app->request->headers->get(Constants::HTTP_DEVICE_TYPE);
            $user->last_device_id = Yii::$app->request->headers->get(Constants::HTTP_DEVICE_ID);
            $user->generateAccessToken();
            $user->save();

            return $user;
        }

        return null;
    }

    /**
     * Finds user by account(include mobile email username)
     *
     * @return User|null
     */
    public function getUser() {
        if ($this->_user === false) {
            $this->_user = User::findByAccount($this->account);
        }

        return $this->_user;
    }
}