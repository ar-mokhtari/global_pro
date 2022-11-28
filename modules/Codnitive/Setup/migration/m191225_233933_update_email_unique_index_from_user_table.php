<?php

use yii\db\Migration;

/**
 * Class m191225_233933_update_email_unique_index_from_user_table
 */
class m191225_233933_update_email_unique_index_from_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // drops index for column `email`
        $this->dropIndex(
            '{{%user_unique_email}}',
            '{{%user}}'
        );

        // creates unique index for columns `email` again
        $this->createIndex(
            '{{%idx-user-email}}',
            '{{%user}}',
            ['email'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `email`
        $this->dropIndex(
            '{{%idx-user-email}}',
            '{{%user}}'
        );

        // creates unique index for columns `email` like before
        $this->createIndex(
            '{{%user_unique_email}}',
            '{{%user}}',
            ['email'],
            true
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191225_233933_update_email_unique_index_from_user_table cannot be reverted.\n";

        return false;
    }
    */
}
