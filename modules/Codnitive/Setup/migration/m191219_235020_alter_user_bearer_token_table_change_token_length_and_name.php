<?php

use yii\db\Migration;

/**
 * Class m191219_235020_alter_user_bearer_token_table_change_token_length_and_name
 * 
 * php yii migrate/create alter_user_bearer_token_table_change_token_length_and_name
 */
class m191219_235020_alter_user_bearer_token_table_change_token_length_and_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // alter table and rename token field into access_token
        $this->renameColumn('{{%user_bearer_token}}', 'token', 'access_token');
        // alter user bearer token table to decrease token length
        $this->alterColumn('{{%user_bearer_token}}', 'access_token', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // alter user bearer token table to restor token length
        $this->alterColumn('{{%user_bearer_token}}', 'access_token', $this->string(128));
        // alter table and back access_token name to token
        $this->renameColumn('{{%user_bearer_token}}', 'access_token', 'token');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191219_235020_alter_user_bearer_token_table_change_token_length_and_name cannot be reverted.\n";

        return false;
    }
    */
}
