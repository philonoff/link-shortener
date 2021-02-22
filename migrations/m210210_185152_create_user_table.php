<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m210210_185152_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string(320)->notNull()->unique(),
            'new_email' => $this->string(320)->null(),
            'username' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->defaultValue(null),
            'email_change_token' => $this->string()->defaultValue(null),
        ]);

        $this->createIndex(
            'password_reset_token',
            'user',
            'password_reset_token'
        );

        $this->createIndex(
            'email_change_token',
            'user',
            'email_change_token'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
