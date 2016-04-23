<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'ucpass' => [
            'class' => 'backend\components\Ucpaas',
            'accountSid' => '3550344c4a362cffbb14ca55b4683772',
            'token' => '2e3fcf93c16a77209145f74e3c234532',
            'appId' => 'a8ef8cf06c1b4cef81ed57d7de7ceead',
            'templateId' => '12084',
        ]
    ],
];
