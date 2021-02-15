<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%country_analytics}}`.
 */
class m210215_155316_create_country_analytics_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%country_analytics}}', [
            'id' => $this->primaryKey(),
            'url_token' => $this->string()->notNull(),
            'country' => $this->string()->notNull(),
            'clicks_amount' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'url_token',
            'country_analytics',
            'url_token'
        );

        $this->createIndex(
            'country',
            'country_analytics',
            'country'
        );

        $this->addForeignKey(
            'url_token',
            'country_analytics',
            'url_token',
            'url',
            'token',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%country_analytics}}');
    }
}
