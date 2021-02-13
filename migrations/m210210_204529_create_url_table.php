<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%url}}`.
 */
class m210210_204529_create_url_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%url}}', [
            'token' => $this->string()->notNull(),
            'long_url' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'expiry_at' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
        ]);

        $this->addPrimaryKey(
            'token',
            'url',
            'token'
        );

        $this->createIndex(
            'user_id',
            'url',
            'user_id'
        );

        $this->addForeignKey(
            'user_id',
            'url',
            'user_id',
            'user',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%url}}');
    }
}
