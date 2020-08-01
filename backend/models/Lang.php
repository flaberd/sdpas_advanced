<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "lang".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $prefix
 * @property string|null $short
 * @property int|null $status
 */
class Lang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['title', 'prefix', 'short'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'prefix' => 'Prefix',
            'short' => 'Short',
            'status' => 'Status',
        ];
    }
}
