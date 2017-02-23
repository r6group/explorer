<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-phi',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'phi\controllers',
    'name' => 'Health Explorer',
//    'bootstrap' => ['log'],
    'bootstrap' => ['debug'],

    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['115.87.214.122', '127.0.0.1', '::1']
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
 
    ],
    'components' => [
//        'cache' => [
//            'class' => 'yii\caching\MemCache',
//            'servers' => [
//                [
//                    'host' => 'localhost',
//                    'port' => 11211,
//                ],
//            ],
//            'useMemcached' => true,
//            'serializer' => false,
//            'options' => [
//                \Memcached::OPT_COMPRESSION => false,
//            ],
//
//        ],

        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => 'themes/quirk/lib/bootstrap/',
                    'js' => ['js/bootstrap.js']
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'on afterLogin' => function (\yii\web\UserEvent $event) {
                /** @var common\models\User $user */
                $user = $event->identity;
                $user->changeUserStatusNewToActive();
            }
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
        'urlManager' => [
            'rules' => [
                //'' => 'site/index',
                //'gii' => 'gii',
                'debug/<controller>/<action>' => 'debug/<controller>/<action>',
                '<_a:(about|contact|captcha|login|signup)>' => 'site/<_a>',
                '<_m>/<_c>/<_a>' => '<_m>/<_c>/<_a>',
                '<_m>/<_c>' => '<_m>/<_c>',
                '<_m>' => '<_m>',
            ]
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'report/*',
            'debug/default*',
            'menu/index',
            'setting/*',
        ]
    ],
    'params' => $params,
];
