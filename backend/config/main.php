<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

use \yii\web\Request;

//$baseUrl = str_replace('/backend/web', '/backend', (new Request)->getBaseUrl());
$baseUrl = str_replace('/backend/web', '/backend', (new Request)->getBaseUrl());
$baseUrlFrontend = str_replace('/backend/web', '', (new Request)->getBaseUrl());

return [
    'id' => 'app-backend',
    'name' => 'Techniansh',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
//    'bootstrap' => ['log'],
    'modules' => [
        'seo' => [
            'class' => 'porcelanosa\yii2seo\Module',
            'uploadPath' => Yii::getAlias('@uploads') . '/',
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl' => $baseUrl,
            'enableCsrfValidation' => true,
        ],
        'rbac' => [
            'class' => 'common\components\RbacComponent',
        ],
        'metadata' => [
            'class' => 'common\components\MetadataComponent',
            'defaultNamespace' => '\\backend\controllers\\'
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_backendUser', // unique for backend
                'path' => '/backend/web'  // correct path for the backend app.
            ]
        ],
        'session' => [
            'name' => 'APTMTBACKSESSID',
            'savePath' => __DIR__ . '/../tmp',
        ],
/*        'log' => [
//            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error'],
                    'categories' => ['yii\db\*'],
                    'message' => [
                        'from' => ['log@example.com'],
                        'to' => ['admin@example.com', 'developer@example.com'],
                        'subject' => 'Database errors at example.com',
                    ],
                ],
            ],
        ],*/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<module>/<controller>/<action>/<id:\d+>' => '<module>/<controller>/<action>',
                'thumb/<module:\w+>/<width:\d+>/<height:\d+>/<img:[a-zA-Z0-9-.]+>' => 'thumb',
            ],
        ],
        'urlManagerFrontEnd' => [
            'class' => 'yii\web\urlManager',
            'baseUrl' => $baseUrlFrontend,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'currencyCode' => '₹',
            'dateFormat' => 'd-M-Y',
            'datetimeFormat' => 'd-M-Y H:i',
            'timeFormat' => 'H:i',
        ],
    ],
    'params' => $params,
];
