<?php

use backend\component\option_top_menu\OptionTopMenu;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\News */

$this->title = Yii::t('app','Редактирование новости: ') . $model->texts->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Все новости'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app','Редактирование');
$this->params['left_top_menu'] = OptionTopMenu::catalogLeftMenu();
$this->params['right_top_menu'] = OptionTopMenu::catalogRightMenu();
?>
<div class="news-update page-wrapper">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'langs' => $langs,
    ]) ?>

</div>
