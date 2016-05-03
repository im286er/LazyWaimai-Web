<?php

namespace restapi\modules\v1;

use common\helpers\Constants;
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
    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            $httpTimeStamp = Yii::$app->request->headers->get(Constants::HTTP_TIMESTAMP);
            $versionName = Yii::$app->request->headers->get(Constants::HTTP_APP_VERSION);
            $deviceId = Yii::$app->request->headers->get(Constants::HTTP_DEVICE_ID);
            $requestType = Yii::$app->request->headers->get(Constants::HTTP_DEVICE_TYPE);

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