<?php
/* @var $this yii\web\View */

use backend\component\option_top_menu\OptionTopMenu;
use kartik\select2\Select2;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app','Настройки');
$this->params['breadcrumbs'][] = $this->title;
$this->params['left_top_menu'] = OptionTopMenu::optionLeftTopMenu();
$this->params['right_top_menu'] = OptionTopMenu::optionRightTopMenu();

?>
<div class="page-wrapper">
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#all"><?=Yii::t('app', 'Общие настройки')?></a>
        </li>
<!--        <li class="">-->
<!--            <a data-toggle="tab" href="#optimaze">--><?//=Yii::t('app', 'Оптимизацыя')?><!--</a>-->
<!--        </li>-->
        <li class="">
            <a data-toggle="tab" href="#customjs"><?=Yii::t('app', 'Кастомный JS')?></a>
        </li>
<!--        <li class="">-->
<!--            <a data-toggle="tab" href="#integration">--><?//=Yii::t('app', 'Интеграцыя')?><!--</a>-->
<!--        </li>-->

    </ul>
    <div class="tab-content">
        <div id="all" class="tab-pane fade in active">
            <h3><?=Yii::t('app', 'Данные')?></h3>
            <?= $form->field($model, 'adminEmail')->textInput()?>
            <hr>
            <img width="150" src="<?=$model->favIcon;?>" alt="">
            <?= $form->field($model, 'favIcon')->widget(InputFile::className(), [
                'language'      => 'ru',
                'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
                'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
                'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                'options'       => ['class' => 'form-control'],
                'buttonOptions' => ['class' => 'btn btn-default'],
                'multiple'      => false       // возможность выбора нескольких файлов
            ])->label(Yii::t('app','Фавикон'));?>
        </div>
<!--        <div id="optimaze" class="tab-pane fade in ">-->
<!--            --><?php //echo $form->field($model, 'assetCompres')->checkbox()?>
<!--        </div>-->
        <div id="customjs" class="tab-pane fade in ">
            <?= $form->field($model, 'binotel')->textarea(['rows' => 10])?>
            <?= $form->field($model, 'gtm_head')->textarea(['rows' => 10])?>
            <?= $form->field($model, 'gtm_end')->textarea(['rows' => 10])?>
        </div>
<!--        <div id="integration" class="tab-pane fade in ">-->
<!--        </div>-->

    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app','Сохранить'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
