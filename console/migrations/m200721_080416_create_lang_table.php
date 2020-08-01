<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%lang}}`.
 */
class m200721_080416_create_lang_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%lang}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'prefix' => $this->string(255),
            'short' => $this->string(255),
            'status' => $this->tinyInteger(1)->defaultValue(0),
        ]);

        $this->insert('lang', [
            'title' => 'Русский',
            'prefix' => 'ru',
            'short' => 'Рус',
            'status' => 1,
        ]);

        $this->insert('lang', [
            'title' => 'Українська',
            'prefix' => 'uk',
            'short' => 'Укр',
            'status' => 1,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%lang}}');
    }
}
