<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

use \yii\web\Request;

$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());

return [
    'id' => 'app-frontend',
    'name' => 'Techniansh',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'thumbnail'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'signup' => [
            'class' => 'frontend\widgets\signup\Module',
        ],
        'contact' => [
            'class' => 'frontend\widgets\contact\Module',
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl' => $baseUrl,
            'enableCsrfValidation' => true,
        ],
        'thumbnail' => [
            'class' => 'common\widgets\thumbnail\EasyThumbnail',
            'cacheAlias' => realpath('Applications\\MAMP\\htdocs\\techniansh\\thumbimages\\'),
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/signin'],
            'identityCookie' => [
                'name' => '_frontendUser', // unique for backend
                'path' => '/frontend/web'  // correct path for the backend app.
            ]
        ],
        'session' => [
            'name' => 'APTMTFRONTSESSID',
            'savePath' => __DIR__ . '/../tmp',
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
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => false,
            ],
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<module>/<controller>/<action>/<id:\d+>' => '<module>/<controller>/<action>',
                'thumb/<module:\w+>/<width:\d+>/<height:\d+>/<img:[a-zA-Z0-9-.]+>' => 'thumb',
                'download/<module:\w+>/<file:[a-zA-Z0-9-.]+>' => 'download',
                'signup' => 'site/signup',
                'signin' => 'site/signin'
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'currencyCode' => '₹',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i',
            'timeFormat' => 'php:H:i',
        ],
    ],
    'params' => $params,
];
