<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $d = new DateTime();
        $this->insert('{{%user}}',[
            'username' => 'admin',
            'auth_key' => 'dszfhfhjyjhygfjhjfgh',
            'email' => 'info@admin.ad',
            'password_hash' => Yii::$app->security->generatePasswordHash(Yii::$app->params['adminPas']),
            'created_at' => $d->format('Y-m-d H:i:S'),
            'updated_at' => $d->format('Y-m-d H:i:S'),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
