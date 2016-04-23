<?php

namespace restapi\modules\v1;

use Yii;
use yii\base\Module;
use yii\web\NotFoundHttpException;


class ApiModule extends Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'restapi\modules\v1\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        Yii::configure($this, require(__DIR__.'/config/main.php'));
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            $httpTimeStamp = Yii::$app->request->headers->get('Http-Timestamp');
            $versionName = Yii::$app->request->headers->get('Http-App-Version');
            $deviceId = Yii::$app->request->headers->get('Http-Device-Id');
            $requestType = Yii::$app->request->headers->get('Http-Request-Type');

            if ($httpTimeStamp === null || $versionName === null
                || $deviceId === null || $requestType === null) {
                throw new NotFoundHttpException('非法访问.');
            }

            return true;
        } else {
            return false;
        }
    }
}