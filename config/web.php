<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'Yd0U7JtWq1CgI-c2_Iv2ci67on5m7zVh',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'loginUrl' => ['admin/login'],
            'identityClass' => 'app\models\Admins',
            'enableAutoLogin' => false,
            'enableSession' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => '',
                'password' => '',
                'port' => '587',
                'encryption' => 'tls',
            ],
            'useFileTransport' => false,
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'catalog' => 'catalog/index',
                'admin' => 'admin/index',
                'admin/images' => 'images/index',
                'admin/images/<action:\w+>/<id:\d+>' => 'images/<action>',
                'admin/contacts' => 'contacts/index',
                'admin/contacts/<action:\w+>/<id:\d+>' => 'contacts/<action>',
                'admin/pages' => 'pages/index',
                'admin/pages/<action:\w+>/<id:\d+>' => 'pages/<action>',
                'admin/items' => 'items/index',
                'admin/items/<action:\w+>/<id:\d+>' => 'items/<action>',
                'admin/partners' => 'partners/index',
                'admin/partners/<action:\w+>/<id:\d+>' => 'partners/<action>',
                '<url:\w+>' => 'site/view',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                'admin/contacts/<action:\w+>' => 'contacts/<action>',
                'admin/images/<action:\w+>' => 'images/<action>',
                'admin/pages/<action:\w+>' => 'pages/<action>',
                'admin/items/<action:\w+>' => 'items/<action>',
                'admin/partners/<action:\w+>' => 'partners/<action>',
            ],
        ],

    ],
    'params' => $params,
    'modules' => [
        'redactor' => [
            'class' => 'yii\redactor\RedactorModule',
            'imageAllowExtensions'=>['jpg','png','gif'],
            'uploadDir' => '@webroot/uploads/pages/',
            'uploadUrl' => '@web/uploads/pages',
            'widgetClientOptions'=>[
                'replaceDivs'=>false,
            ]
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
