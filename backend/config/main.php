<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'language' => 'ru',
    'sourceLanguage' => 'ru',
    'bootstrap' => ['log'],
    'modules' => [
        'yii2images' => [
//            'class' => 'rico\yii2images\Module',
            'class' => 'common\lib\costarico_mod\ModuleMod',
            //be sure, that permissions ok
            //if you cant avoid permission errors you have to create "images" folder in web root manually and set 777 permissions
            'imagesStorePath' => '@frontend/web/files', //path to origin images
            'imagesCachePath' => '@frontend/web/cache', //path to resized copies
            'graphicsLibrary' => 'GD', //but really its better to use 'Imagick'
            'placeHolderPath' => '@frontend/web/files/placeHolder.png', // if you want to get placeholder when image not exists, string will be processed by Yii::getAlias
//            'imageCompressionQuality' => 100, // Optional. Default value is 85.
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/weadmin'
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceLanguage' => 'ru',
                ]
            ]
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'suffix' => '.html',
            'rules' => [
                '' => 'site/index',
                'option' => 'option/index',



//                '<action>'=>'site/<action>',
            ],
        ],
        'urlManagerFrontend' => [
            'class' => 'yii\web\UrlManager',
            'baseUrl' => '',
//            'hostInfo' => 'http://domain.ru',
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
        ],
    ],
    'controllerMap' => [
        'elfinder' => [
            'class' => 'mihaildev\elfinder\PathController',
            'access' => ['@'],
            'disabledCommands' => ['netmount'],
            'root' => [
                'baseUrl'=>'/files',
                'basePath'=>'@frontend/web/files',
                'name' => 'Files'
            ]
        ]
    ],
    'params' => $params,
];
