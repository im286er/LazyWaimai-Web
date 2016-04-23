<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-restapi',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'restapi\controllers',
    'modules' => [
        'v1' => [
            'class' => 'restapi\modules\v1\ApiModule'
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'restapi\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'site/<action:\w+>' => 'site/<action>',

                'PUT,PATCH <version:\w+>/<parent_ctl:\w+>/<parent_id:\d+>/<controller:\w+>/<id:\d+>' =>
                    '<version>/<controller>/update',
                'DELETE <version:\w+>/<parent_ctl:\w+>/<parent_id:\d+>/<controller:\w+>/<id:\d+>' =>
                    '<version>/<controller>/delete',
                'GET,HEAD <version:\w+>/<parent_ctl:\w+>/<parent_id:\d+>/<controller:\w+>/<id:\d+>' =>
                    '<version>/<controller>/view',
                'POST <version:\w+>/<parent_ctl:\w+>/<parent_id:\d+>/<controller:\w+>' =>
                    '<version>/<controller>/create',
                'GET,HEAD <version:\w+>/<parent_ctl:\w+>/<parent_id:\d+>/<controller:\w+>' =>
                    '<version>/<controller>/index',

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v1/address',
                        'v1/business',
                        'v1/user',
                        'v1/code',
                        'v1/order',
                    ],
                    'extraPatterns' => [
                        'POST check' => 'check'
                    ],
                ],
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
