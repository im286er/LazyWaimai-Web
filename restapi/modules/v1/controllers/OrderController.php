<?php

namespace app\modules\v1\controllers;


use restapi\modules\v1\models\CartExtra;
use restapi\modules\v1\models\CartProduct;
use yii;
use yii\web\ForbiddenHttpException;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use restapi\modules\v1\models\SettleBody;
use restapi\modules\v1\models\SettleResult;
use restapi\components\HttpTokenAuth;
use restapi\modules\v1\models\Order;
use JMS\Serializer\SerializerBuilder;


class OrderController extends ActiveController {

    public $modelClass = 'app\modules\v1\models\Order';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items'
    ];

    /**
     * 重写行为方法，自定义身份认证类
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpTokenAuth::className(),
        ];

        return $behaviors;
    }


    /**
     * 重写此方法，更改prepareDataProvider
     * @inheritdoc
     */
    public function actions() {
        $actions['index'] = [
            'class' => 'yii\rest\IndexAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'prepareDataProvider' => [$this, 'prepareDataProvider'],
        ];
        $actions['view'] = [
            'class' => 'yii\rest\ViewAction',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
        ];

        return $actions;
    }

    /**
     * 定制DataProvider
     * @return ActiveDataProvider
     */
    public function prepareDataProvider() {
        return new ActiveDataProvider([
            'query' => Order::find()->where([
                'and',
                ['user_id' => Yii::$app->user->getId()],
                ['>', 'status', Order::STATUS_WAIT_SUBMIT]
            ])->orderBy('created_at desc'),
        ]);
    }

    /**
     * 订单结算
     * @return SettleResult $settleResult
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     */
    public function actionCheck() {
        // 将传递的json数据转化为指定的类对象
        $serializer = SerializerBuilder::create()->build();
        /** @var $settleBody SettleBody */
        $settleBody = $serializer->deserialize(Yii::$app->request->rawBody,
            'restapi\modules\v1\models\SettleBody', 'json');

        $cartProductList = CartProduct::handleCartProduct($settleBody);

        $cartExtraFeeList = CartExtra::handleCartExtraFee($settleBody);

        // 订单结算结果
        $settleResult = new SettleResult($settleBody);

        return $settleResult;
    }

    /**
     * 订单提交
     * @return Order $order
     * @throws BadRequestHttpException
     * @throws ServerErrorHttpException
     */
    public function actionCreate() {
        $sign = Yii::$app->request->getBodyParam('sign');
        $bookedAt = Yii::$app->request->getBodyParam('booked_at');
        $remark = Yii::$app->request->getBodyParam('remark');
        if ($sign === null) {
            throw new BadRequestHttpException('缺少必需的参数: sign');
        }

        $order = Order::find()->where(['sign' => $sign])->one();
        if ($order === null) {
            throw new BadRequestHttpException('无效的参数: sign');
        } else if ($order instanceof Order) {
            $order->remark = $remark;
            $order->booked_at = $bookedAt;
            if ($order->pay_method == Order::PAYMENT_ONLINE) {
                $order->status = Order::STATUS_WAIT_PAYMENT;
            } else {
                $order->status = Order::STATUS_WAIT_ACCEPT;
            }
            $order->created_at = time();

            if ($order->save() === false) {
                throw new ServerErrorHttpException('系统出现异常，请稍后重试');
            }

            return $order;
        } else {
            throw new ServerErrorHttpException('系统出现异常，请稍后重试');
        }
    }

    /**
     * 检查登录的用户是否有操作此订单的权限
     * @param string $action
     * @param null $model
     * @param array $params
     * @throws ForbiddenHttpException
     */
    public function checkAccess($action, $model = null, $params = []) {
        if ($model !== null && $model['user_id'] != Yii::$app->user->getId()) {
            throw new ForbiddenHttpException('You do not have permission to operate this resource.');
        }
    }
}