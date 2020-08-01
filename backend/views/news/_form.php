<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin([
        'id' => 'rooms_form'
    ]); ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app','Сохранить'), ['class' => 'btn btn-success']) ?>
        </div>
        <ul class="nav nav-tabs">
            <li class="active">
                <a class="flab_tab" href="#data"><?=Yii::t('app','Данные')?></a>
            </li>
            <li class="">
                <a class="flab_tab" href="#seo"><?=Yii::t('app','Тексты')?></a>
            </li>
            <!--        <li class="">-->
            <!--            <a class="flab_tab" href="#blocks">--><?//=Yii::t('app','Блоки')?><!--</a>-->
            <!--        </li>-->
        </ul>
        <div class="flab_tab-content">
            <div id="data" class="flab_tab-pane" style="display: block;">
                <?= $form->field($model, 'status')->checkbox()?>
                <?= $form->field($model, 'seo_url')->textInput(['maxlength' => true]) ?>
                <?php
                $main_img=$model->getImageByName('main_img');
                if($main_img!=null){ ?>
                    <img width="" src="<?=$main_img->getPathSVG('150x');?>" alt="">
                <?php } ?>
                <?= $form->field($model, 'main_img')->widget(InputFile::className(), [
                    'language'      => 'ru',
                    'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                    'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                    'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                    'options'       => ['class' => 'form-control'],
                    'buttonOptions' => ['class' => 'btn btn-default'],
                    'multiple'      => false       // возможность выбора нескольких файлов
                ])->label(Yii::t('app','Картинка в тизер'));?>
            </div>
            <div id="seo" class="flab_tab-pane" style="display: none;">
                <ul class="nav nav-tabs">
                    <?php $i=1; foreach ($langs as $lang){ ?>
                        <li class="<?=$i===1?'active':''?>">
                            <a data-toggle="tab" href="#lang_<?=$lang->id?>_footer"><?=$lang->title;?>
                            </a>
                        </li>
                        <?php $i++; } ?>
                </ul>
                <div class="tab-content">
                    <?php $k=1; foreach ($langs as $lang){ ?>
                        <div id="lang_<?=$lang->id?>_footer" class="tab-pane fade in <?=$k===1?'active':''?>">
                            <?= $form->field($model, 'langs['.$lang->id.'][title]')->textInput(['maxlength' => true])->label(Yii::t('app','Название')) ?>
                            <?= $form->field($model, 'langs['.$lang->id.'][exerpt]')->textarea(['maxlength' => true])->label(Yii::t('app','Краткое описание')) ?>
                            <?= $form->field($model, 'langs['.$lang->id.'][text]')->widget(CKEditor::className(),[
                                'options' => [
                                ],
                                'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder',[
                                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                    'inline' => false, //по умолчанию false
                                    'allowedContent' => true,
                                ]),
                            ])->label(Yii::t('app','Описание')) ?>
                            <?= $form->field($model, 'langs['.$lang->id.'][seo_title]')->textInput(['maxlength' => true])->label(Yii::t('app','Мета Название')) ?>
                            <?= $form->field($model, 'langs['.$lang->id.'][seo_desc]')->textInput(['maxlength' => true])->label(Yii::t('app','Мета Описание')) ?>
                        </div>
                        <?php $k++; } ?>
                </div>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
