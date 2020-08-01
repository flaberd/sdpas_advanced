<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "option".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $value
 */
class Option extends \yii\db\ActiveRecord
{
    public $curentLang;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'option';
    }

    public function behaviors()
    {
        $this->curentLang = Lang::find()->where(['prefix'=>Yii::$app->language])->one();
        return [
            'image' => [
//				'class' => 'rico\yii2images\behaviors\ImageBehave',
                'class' => 'common\lib\costarico_mod\ImageBehaveModifed',
            ]
        ];
    }

    public function getTexts(){
        return $this->hasOne(OptionLang::className(),['option_id' => 'id'])
            ->andOnCondition(['lang_id' => $this->curentLang->id]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }
}
