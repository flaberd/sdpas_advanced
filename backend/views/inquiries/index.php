<?php

use backend\component\option_top_menu\OptionTopMenu;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','Запроси');
$this->params['breadcrumbs'][] = $this->title;
$this->params['left_top_menu'] = OptionTopMenu::inqLeftMenu();
?>
<div class="inquiries-index page-wrapper">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'created_at',
            [
                'attribute' => 'created_at',
                'value' => function($data){
                    $d = new DateTime($data->created_at);
                    return $d->format('d-m-Y H:i');
                }
            ],
//            'updated_at',
            'name',
            'phone',
            //'email:email',
            //'page',
            //'element',
            //'data',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]); ?>


</div>
