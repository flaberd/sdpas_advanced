<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Inquiries */

$this->title = 'Create Inquiries';
$this->params['breadcrumbs'][] = ['label' => 'Inquiries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inquiries-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
