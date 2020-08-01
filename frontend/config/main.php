<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'language' => 'ru',
    'sourceLanguage' => 'ru',
    'modules' => [
        'gii' => 'yii\gii\Module',
        'yii2images' => [
//            'class' => 'rico\yii2images\Module',
            'class' => 'common\lib\costarico_mod\ModuleMod',
            //be sure, that permissions ok
            //if you cant avoid permission errors you have to create "images" folder in web root manually and set 777 permissions
            'imagesStorePath' => '@frontend/web/files', //path to origin images
            'imagesCachePath' => '@frontend/web/cache', //path to resized copies
            'graphicsLibrary' => 'GD', //but really its better to use 'Imagick'
            'placeHolderPath' => '@frontend/web/files/placeHolder.png', // if you want to get placeholder when image not exists, string will be processed by Yii::getAlias
            'imageCompressionQuality' => 70, // Optional. Default value is 85.
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
//            'class' => 'codemix\localeurls\UrlManager',
            'class' => 'common\lib\UrlManagerByFlaberd',
//            'languages' => ['ru','uk'],
//            'languages' => [],
            'enableDefaultLanguageUrlCode' => false,
            'enableLanguageDetection' => false,
//            'enableDefaultLanguageUrlCode' => true,
//            'enableLanguagePersistence' => false,

            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'suffix' => '.html',
            'rules' => [
                'sitemap.xml' => 'sitemap/index',
                'services' => 'site/services',
                'about' => 'site/about',
                'rooms' => 'site/rooms',
                'news' => 'news/index',
                'news/<seo_url>' => 'news/show',
                'contact' => 'site/contact',
                'room/<seo_url>' => 'site/room',
                'banqueting-hall' => 'site/banqueting-hall',
                'conference-hall' => 'site/conference-hall',
//
////                [
////                    'pattern' => '/<seo_url:\S+>',
////                    'route' => 'site/index',
////                    'defaults' => ['seo_url' => '<seo_url:\S+>'],
////                ],
//                '/thank-you' => 'site/thank-you',
//                '/tehnika/<seo_url>'=>'site/tehnika',
//                '/category/<seo_url>'=>'site/category',
//                '/category'=>'site/category',
//                '<seo_url>'=>'site/index',
                '' => 'site/index',
            ],
        ],
//        'urlManager' => [
//            'enablePrettyUrl' => true,
//            'showScriptName' => false,
//            'rules' => [
//            ],
//        ],

    ],
    'params' => $params,
];
