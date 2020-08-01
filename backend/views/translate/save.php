<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\web\View;

?>
<?= Html::beginForm(['translate/save'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
<?= Html::input('text', 'string', $string, ['class' => 'form-control']) ?>
<?= Html::input('hidden', 'lang', $lang, []) ?>
<?= Html::input('hidden', 'id', $id, []) ?>
<?= Html::submitButton(Yii::t('app','Сохранить'), ['class' => 'btn btn-lg btn-primary', 'name' => 'hash-button']) ?>
<?= Html::endForm() ?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-check"></i><?= Yii::$app->session->getFlash('success') ?></h4>
    </div>
    <?php
    $this->registerJs(
        "setTimeout(function(){
            $('.alert').fadeOut('slow');
        }, 5000);",
        View::POS_END,
        'alert-close'
    );
    ?>
<?php endif; ?>
