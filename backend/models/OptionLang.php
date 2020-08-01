<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "option_lang".
 *
 * @property int $id
 * @property int|null $option_id
 * @property int|null $lang_id
 * @property string|null $data
 */
class OptionLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'option_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['option_id', 'lang_id'], 'integer'],
            [['data'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'option_id' => 'Option ID',
            'lang_id' => 'Lang ID',
            'data' => 'Data',
        ];
    }
}
