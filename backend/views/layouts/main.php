<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;
use kartik\nav\NavX;
use kartik\sidenav\SideNav;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="icon" type="image/png" href="/backend/web/favicon.png">
    <?php $this->head() ?>
    <script type="text/javascript">
        var urlPrefix = '<?=Yii::$app->language=='ru'?'':'/'.Yii::$app->language?>';
    </script>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <!--    --><?php
    //    NavBar::begin([
    //        'brandLabel' => Yii::$app->name,
    //        'brandUrl' => Yii::$app->homeUrl,
    //        'options' => [
    //            'class' => 'navbar-inverse navbar-fixed-top',
    //        ],
    //    ]);
    //    $menuItems = [
    //        ['label' => 'Home', 'url' => ['/site/index']],
    //    ];
    //    if (Yii::$app->user->isGuest) {
    //        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    //    } else {
    //        $menuItems[] = '<li>'
    //            . Html::beginForm(['/site/logout'], 'post')
    //            . Html::submitButton(
    //                'Logout (' . Yii::$app->user->identity->username . ')',
    //                ['class' => 'btn btn-link logout']
    //            )
    //            . Html::endForm()
    //            . '</li>';
    //    }
    //    echo Nav::widget([
    //        'options' => ['class' => 'navbar-nav navbar-right'],
    //        'items' => $menuItems,
    //    ]);
    //    NavBar::end();
    //    ?>

    <div class="admin_header flex flex_between">
        <div class="flex_sidebar">
        </div>
        <div class="admin_header_inner flex flex_between flex_content">
            <div class="admin_header_logo">
                <a href="<?= Url::to(['/']) ?>" title="">
                    <img src="/backend/web/images/logo.svg" alt="">
                </a>
            </div>
            <div class="admin_header_menu">
                <ul class="flex flex_end">
                    <li>
                        <a href="#" title="">Some link</a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/site/logout']) ?>" class="admin_header_logout" data-toggle="tooltip" data-placement="left" title="Выйти">
                            <span class="glyphicon glyphicon-log-out"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="admin_content flex flex_between">
        <div class="sidebar_menu flex_sidebar">
            <?php
            if (!Yii::$app->user->isGuest) {
//                        if (Yii::$app->user->isGuest) {
//                            $auth = ['label' => Yii::t('app','Войти'), 'url' => ['/site/login']];
//                        } else {
//                            $auth = '<li>'
//                                . Html::beginForm(['/site/logout'], 'post')
//                                . Html::submitButton(
//                                    Yii::t('app','Выйти').' (' . Yii::$app->user->identity->username . ')',
//                                    ['class' => 'btn btn-link logout']
//                                )
//                                . Html::endForm()
//                                . '</li>';
//                        }
                echo SideNav::widget([
                    'type' => SideNav::TYPE_DEFAULT,
                    // 'heading' => '<a href="' . Url::to(['/']) . '">Smart-landing</a>',
                    'items' => [
                        [
                            'url' => Url::to(['/rooms']),
                            'label' => Yii::t('app', 'Каталог'),
                            'icon' => 'folder-open',
                            'active' =>
                                stripos(Yii::$app->controller->route, 'rooms/') === 0
                                || stripos(Yii::$app->controller->route, 'services/') === 0
                                || stripos(Yii::$app->controller->route, 'services-cat/') === 0
                            ,
                        ],



//                        [
//                            'url' => Url::to(['/page']),
//                            'label' => Yii::t('app', 'Страницы'),
//                            'icon' => 'file',
//                            'active' =>
//                                stripos(Yii::$app->controller->route, 'page/') === 0
//                            ,
//                        ],
                        [
                            'url' => Url::to(['/inquiries']),
                            'label' => Yii::t('app', 'Запроси'),
                            'icon' => 'inbox',
                            'active' =>
                                stripos(Yii::$app->controller->route, 'inquiries/') === 0
//                                    || stripos(Yii::$app->controller->route, 'reviews/') === 0
                            ,
                        ],
//                            [
//                                'url' => Url::to(['/product']),
//                                'label' => Yii::t('app', 'Каталог'),
//                                'icon' => 'file',
//                                'active' =>
//                                    stripos(Yii::$app->controller->route, 'product/') === 0
//                                ,
//                            ],
                        [
                            'url' => Url::to(['option/index']),
                            'label' => Yii::t('app', 'Настройки'),
                            'icon' => 'cog',
                        ],
                        [
                            'label' => Yii::t('app','Выйти'),
                            'url' => ['/site/logout']
                        ],
                    ],
                ]);
            }
            ?>
        </div>
        <div class="flex_content">
            <div class="top_menu clearfix">
                <?php
                echo NavX::widget([
                    'options' => ['class' => 'navbar-nav'],
                    'items' => $this->params['left_top_menu']??[],
                    'activateParents' => true,
                    'encodeLabels' => false
                ]);
                echo NavX::widget([
                    'options' => ['class' => 'navbar-nav navbar-right'],
                    'items' => $this->params['right_top_menu']??[],
                    'activateParents' => true,
                    'encodeLabels' => false
                ]);
                ?>
            </div>
            <div class="admin_content_inner">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
