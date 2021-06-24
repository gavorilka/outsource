<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ictoulcolucluyfo6ufdo75uoulo76do',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        /*'cache' => [
            'class' => 'yii\caching\FileCache',
        ],*/
        'user' => [
            'identityClass' => 'app\models\User',
            //'enableAutoLogin' => true,
            'enableSession' => false
        ],
        /*'errorHandler' => [
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
        ],*/
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'caseSensitive' => false,
            'rules' => [
                'POST join' => 'user/login',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['user'],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['performers'],
                    'prefix' => 'api/',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['orders'],
                    'prefix' => 'api/',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['details'],
                    'prefix' => 'api/',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['organizations'],
                    'prefix' => 'api/',
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['professions'],
                    'prefix' => 'api/',
                ]
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
