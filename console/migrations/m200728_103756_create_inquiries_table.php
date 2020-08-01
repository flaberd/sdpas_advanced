<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%inquiries}}`.
 */
class m200728_103756_create_inquiries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%inquiries}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime()->defaultValue(new \yii\db\Expression('NOW()')),
            'updated_at' => $this->dateTime()->defaultValue(new \yii\db\Expression('NOW()')),
            'name' => $this->string(255),
            'phone' => $this->string(255),
            'email' => $this->string(255),
            'page' => $this->string(),
            'element' => $this->string(),
            'data' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%inquiries}}');
    }
}
