<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'news',
    'modules' => [
        'news' => [
            'class' => 'app\modules\news\News',
        ],
        'ecategory' => [
            'class' => 'app\modules\ecategory\ECategory',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Krt5-_Lz_g4eXIPXNOfqAeq3VC5vgUtp',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'edit-categories/<action-do:(index|create)>' => 'ecategory/ecategory/<action-do>',
                'edit-categories/<action-do:(update)>/<id:\d+>' => 'ecategory/ecategory/<action-do>',
                'edit-news/<action-do:(index|create)>' => 'news/news/<action-do>',
                'edit-news/<action-do:(update|view)>/<id:\d+>' => 'news/news/<action-do>',
                'news-view/<id:\d+>' => 'news/default/view',
                'page/<page:\d+>/col/<per-page:\d+>' => 'news/default/index',
                'category/<idcategory:\d+>' => 'news',
                'tag/<idtag:\d+>' => 'news',
                '' => 'news',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
