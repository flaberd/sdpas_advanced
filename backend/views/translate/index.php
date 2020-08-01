<?php
/* @var $this yii\web\View */

use backend\component\option_top_menu\OptionTopMenu;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = Yii::t('app','Переводы');
$this->params['breadcrumbs'][] = $this->title;
$this->params['left_top_menu'] = OptionTopMenu::optionLeftTopMenu();
$this->params['right_top_menu'] = OptionTopMenu::optionRightTopMenu();
?>
<?php //debug(Yii::$app->sourceLanguage); ?>
<table class="table page-wrapper">
    <thead>
    <tr>
<!--        <th scope="col">#</th>-->
        <th scope="col"><?= Yii::t('app', 'Категория')?></th>
        <th scope="col"><?= Yii::t('app', 'Источник')?></th>
        <?php foreach ($langs as $lang){ ?>
            <?php if(Yii::$app->sourceLanguage == $lang->prefix) continue;?>
            <th scope="col"><?=$lang->short?></th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php if(!empty($messages)){ ?>
        <?php foreach ($messages as $message){ ?>
                <tr>
            <!--        <th scope="row">1</th>-->
                    <td><?=$message->category?></td>
                    <td class="translate_text"><?=$message->message?></td>
                    <?php foreach ($langs as $lang){ ?>
                        <?php if(Yii::$app->sourceLanguage == $lang->prefix) continue;?>
                        <td class="translate_form">
                            <?php Pjax::begin([
                                'enablePushState' => false,
                                'timeout' => 10000
                            ]); ?>
                                <?= Html::beginForm(['translate/save'], 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
                                <?= Html::input('text', 'string', $message->messages[$lang->prefix]->translation, ['class' => 'form-control']) ?>
                                <?= Html::input('hidden', 'lang', $message->messages[$lang->prefix]->language, []) ?>
                                <?= Html::input('hidden', 'id', $message->messages[$lang->prefix]->id, []) ?>
                                <?= Html::submitButton(Yii::t('app','Сохранить'), ['class' => 'btn btn-lg btn-primary', 'name' => 'hash-button']) ?>
                                <?= Html::endForm() ?>
                            <?php Pjax::end(); ?>
<!--                            <input type="text" class="form-control" value="--><?php //echo $message->messages[$lang->prefix]->translation?><!--">-->
                        </td>
                    <?php } ?>
                </tr>
<!--            --><?php //debug($message); ?>
        <?php } ?>
    <?php } ?>
<!--    <tr>-->
<!--        <th scope="row">2</th>-->
<!--        <td>Jacob</td>-->
<!--        <td>Thornton</td>-->
<!--        <td>@fat</td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <th scope="row">3</th>-->
<!--        <td>Larry</td>-->
<!--        <td>the Bird</td>-->
<!--        <td>@twitter</td>-->
<!--    </tr>-->
    </tbody>
</table>

