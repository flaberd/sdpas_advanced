<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%option_lang}}`.
 */
class m200727_134906_create_option_lang_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%option_lang}}', [
            'id' => $this->primaryKey(),
            'option_id' => $this->integer(),
            'lang_id' => $this->integer(),
            'data' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%option_lang}}');
    }
}
