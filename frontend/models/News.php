<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string|null $add_date
 * @property string|null $seo_url
 * @property int|null $status
 */
class News extends \yii\db\ActiveRecord
{

    public $curentLang;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
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
        return $this->hasOne(NewsLang::className(),['news_id' => 'id'])
            ->andOnCondition(['lang_id' => $this->curentLang->id]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['add_date'], 'safe'],
            [['status'], 'integer'],
            [['seo_url'], 'string', 'max' => 255],
            [['seo_url'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'add_date' => 'Add Date',
            'seo_url' => 'Seo Url',
            'status' => 'Status',
        ];
    }
}
