<?php

use backend\component\option_top_menu\OptionTopMenu;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title=Yii::t('app','Языки');
$this->params['breadcrumbs'][] = $this->title;
$this->params['left_top_menu'] = OptionTopMenu::optionLeftTopMenu();
$this->params['right_top_menu'] = OptionTopMenu::optionRightTopMenu();
?>
<div class="lang-index page-wrapper">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'prefix',
            'short',
            'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
