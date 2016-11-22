<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timezone' => 'America/New_York',
    'language' => 'en-US',
    'sourceLanguage' => 'en-US',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
