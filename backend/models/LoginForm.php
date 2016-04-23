<?php

namespace backend\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model {

    public $phone;
    public $code;
    public $remember;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['phone', 'code'], 'required'],
            ['remember', 'boolean'],
            ['code', 'validateCode'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'phone' => '手机号',
            'code' => '验证码',
            'remember' => '下次记住我'
        ];
    }

    /**
     * 验证码手机号和验证码是否正确
     */
    public function validateCode() {
        if (!$this->hasErrors()) {
            $session = Yii::$app->session;
            $admin = Admin::findOne(['phone' => $this->phone]);
            if (!$admin) {
                $this->addError('phone', '不存在该手机号！');
            } else if ($session['loginVerifyCode'] != $this->code) {
                $this->addError('code', '验证码不正确！');
            }
        }
    }

    /**
     * 执行用户登录
     * @return bool
     */
    public function login() {
        if ($this->validate()) {
            /** @var $admin Admin */
            $admin = Admin::findOne(['phone' => $this->phone]);

            return Yii::$app->user->login($admin, $this->remember ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }
}
