<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news_lang}}`.
 */
class m200721_082649_create_news_lang_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news_lang}}', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer(),
            'lang_id' => $this->integer(),
            'title' => $this->string(255),
            'text' => $this->text(),
            'seo_title' => $this->string(255),
            'seo_desc' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news_lang}}');
    }
}
