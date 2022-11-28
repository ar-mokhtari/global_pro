<?php

use yii\db\Migration;

/**
 * Class m191219_154848_alter_user_table_extend_fullname_length_value
 * 
 * php yii migrate/create alter_user_table_extend_fullname_length_value
 */
class m191219_154848_alter_user_table_extend_fullname_length_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // alter fullname column from user table to extend length
        $this->alterColumn('{{%user}}', 'fullname', $this->string(96));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // alter fullname column from user table to restor length
        $this->alterColumn('{{%user}}', 'fullname', $this->string(32));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191219_154848_alter_user_table_extend_fullname_length_value cannot be reverted.\n";

        return false;
    }
    */
}
