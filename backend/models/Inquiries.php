<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "inquiries".
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $page
 * @property string|null $element
 * @property string|null $data
 */
class Inquiries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inquiries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'phone', 'email', 'page', 'element', 'data'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => Yii::t('app','Дата добавления'),
            'updated_at' => Yii::t('app','Дата обновления'),
            'name' => Yii::t('app','Имя'),
            'phone' => Yii::t('app','Телефон'),
            'email' => 'Email',
            'page' => Yii::t('app','Страница'),
            'element' => Yii::t('app','Элемент'),
            'data' => 'Data',
        ];
    }
}
