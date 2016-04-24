<?php

namespace backend\controllers;

use backend\models\Admin;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use backend\models\LoginForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginSendSmsForm;
use yii\web\NotFoundHttpException;


/**
 * 操作用户相关的控制器
 * Class UserController
 * @package backend\controllers
 */
class UserController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'send-sms'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'send-sms'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'login' => ['get', 'post'],
                    'logout' => ['get'],
                    'send-sms' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 个人资料的操作
     */
    public function actionView() {
        /* @var $model Admin */
        $model = Admin::findOne(Yii::$app->user->id);

        if (!$model) {
            throw new NotFoundHttpException('未找到该管理员。');
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', '个人资料修改成功.');
            } else {
                Yii::$app->session->setFlash('success', '个人资料修改失败.');
            }
        }

        return $this->render('form', [
            'model' => $model
        ]);
    }

    /**
     * 用户登录的操作
     */
    public function actionLogin() {
        $this->layout = 'base';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['site/index']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 用户注销登录的操作
     */
    public function actionLogout() {
        if (Yii::$app->user->logout()) {
            return $this->redirect(['user/login']);
        } else {
            return $this->goBack();
        }
    }

    /**
     * 通过ajax发送验证码的操作
     * @return array
     */
    public function actionSendSms() {
        $model = new LoginSendSmsForm();
        $model->phone = Yii::$app->request->post('phone');

        if ($model->sendSms()) {
            echo Json::encode(['status' => 'ok']);
        } else {
            $message = $model->getFirstError('phone');
            echo Json::encode(['status' => 'err', 'message' => $message]);
        }
    }
}