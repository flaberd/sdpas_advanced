<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "news_lang".
 *
 * @property int $id
 * @property int|null $news_id
 * @property int|null $lang_id
 * @property string|null $title
 * @property string|null $text
 * @property string|null $seo_title
 * @property string|null $seo_desc
 * @property string|null $exerpt
 */
class NewsLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_id', 'lang_id'], 'integer'],
            [['text','exerpt'], 'string'],
            [['title', 'seo_title', 'seo_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'News ID',
            'lang_id' => 'Lang ID',
            'title' => 'Title',
            'text' => 'Text',
            'seo_title' => 'Seo Title',
            'seo_desc' => 'Seo Desc',
            'exerpt' => ''
        ];
    }
}
