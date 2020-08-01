<?php

use backend\component\option_top_menu\OptionTopMenu;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','Новости');
$this->params['breadcrumbs'][] = $this->title;
$this->params['left_top_menu'] = OptionTopMenu::catalogLeftMenu();
$this->params['right_top_menu'] = OptionTopMenu::catalogRightMenu();
?>
<div class="news-index page-wrapper">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app','Добавить новость'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => Yii::t('app','Название'),
                'value' => function($data){
                    return $data->texts['title'];
                }
            ],
            'seo_url:url',
            'add_date',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>


</div>
