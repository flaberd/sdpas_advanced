<?php


namespace backend\component\option_top_menu;


use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class OptionTopMenu extends Widget
{
    /**
     * Меню опцій
     * @return array[]
     */
    public static function optionLeftTopMenu(){
        return [
            [
                'label' => Yii::t('app', 'Общие настройки'),
                'url' => Url::to(['/option']),
                'active' => Yii::$app->controller->route==='option/index',
            ],
            [
                'label' => Yii::t('app', 'Языки'),
                'url' => Url::to(['/lang']),
                'active' => Yii::$app->controller->route==='lang/index',
            ],
            [
                'label' => Yii::t('app', 'Страницы'),
                'active' => stripos(Yii::$app->controller->route, 'page-options/') === 0,
                'items' => [
                    [
                        'url' => Url::to(['page-options/main']),
                        'label' => Yii::t('app', 'Главная'),
                        'active' => stripos(Yii::$app->controller->route, 'page-options/main') === 0,
                    ],
                    [
                        'url' => Url::to(['page-options/about']),
                        'label' => Yii::t('app', 'Об отеле'),
                        'active' => stripos(Yii::$app->controller->route, 'page-options/about') === 0,
                    ],
                    [
                        'url' => Url::to(['page-options/contact']),
                        'label' => Yii::t('app', 'Контакты'),
                        'active' => stripos(Yii::$app->controller->route, 'page-options/contact') === 0,
                    ],
                    [
                        'url' => Url::to(['page-options/conference-hall']),
                        'label' => Yii::t('app', 'Конференс зал'),
                        'active' => stripos(Yii::$app->controller->route, 'page-options/conference-hall') === 0,
                    ],
                    [
                        'url' => Url::to(['page-options/banqueting-hall']),
                        'label' => Yii::t('app', 'Банкетный зал'),
                        'active' => stripos(Yii::$app->controller->route, 'page-options/banqueting-hall') === 0,
                    ],
                ],
            ],
            [
                'label' => Yii::t('app', 'Переводы'),
                'url' => Url::to(['translate/index']),
                'active' => Yii::$app->controller->route==='translate/index',
            ],
        ];
    }

    public static function optionRightTopMenu(){
        return [
//            [
//                'label' => Yii::t('app', 'Языки'),
//                'url' => Url::to(['/lang']),
//                'active' => Yii::$app->controller->route==='lang/index',
//            ],
        ];
    }

    /**
     * Меню каталога
     * @return array[]
     */
    public static function catalogLeftMenu(){
        return [
            [
                'url' => Url::to(['/rooms']),
                'label' => Yii::t('app', 'Номера'),
                'active' => stripos(Yii::$app->controller->route, 'rooms/') === 0,
            ],
            [
//                'url' => Url::to(['/services']),
                'label' => Yii::t('app', 'Сервисы'),
                'active' => stripos(Yii::$app->controller->route, 'services/') === 0,
                'items' => [
                    [
                        'url' => Url::to(['/services']),
                        'label' => Yii::t('app', 'Сервисы'),
                        'active' => stripos(Yii::$app->controller->route, 'services/') === 0,
                    ],
                    [
                        'url' => Url::to(['/services-cat']),
                        'label' => Yii::t('app', 'Ктегории сервисов'),
                        'active' => stripos(Yii::$app->controller->route, 'services-cat/') === 0,
                    ],
                ],
            ],
            [
                'url' => Url::to(['/news']),
                'label' => Yii::t('app', 'Новости'),
                'active' => stripos(Yii::$app->controller->route, 'news/') === 0,
            ],
        ];
    }
    public static function catalogRightMenu(){
        return [
        ];
    }



    public static  function inqLeftMenu(){
        return [
            [
                'url' => Url::to(['/inquiries']),
                'label' => Yii::t('app', 'Запросы'),
                'active' => stripos(Yii::$app->controller->route, 'inquiries/') === 0,
            ],
//            [
//                'url' => Url::to(['/order']),
//                'label' => Yii::t('app', 'Заказы'),
//                'active' => stripos(Yii::$app->controller->route, 'order/') === 0,
//            ],
        ];
    }
}