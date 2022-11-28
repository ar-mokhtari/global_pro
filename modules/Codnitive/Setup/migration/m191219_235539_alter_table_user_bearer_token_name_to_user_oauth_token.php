<?php

use yii\db\Migration;

/**
 * Class m191219_235539_alter_table_user_bearer_token_name_to_user_oauth_token
 * 
 * php yii migrate/create alter_table_user_bearer_token_name_to_user_oauth_token
 */
class m191219_235539_alter_table_user_bearer_token_name_to_user_oauth_token extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('{{%user_bearer_token}}', '{{%user_oauth_token}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('{{%user_oauth_token}}', '{{%user_bearer_token}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191219_235539_alter_table_user_bearer_token_name_to_user_oauth_token cannot be reverted.\n";

        return false;
    }
    */
}
