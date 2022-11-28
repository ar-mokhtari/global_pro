<?php

use yii\db\Migration;

/**
 * Class m191225_222712_alter_column_email_null_from_user_table
 */
class m191225_222712_alter_column_email_null_from_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'email', $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'email', $this->string(255)->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191225_222712_alter_column_email_null_from_user_table cannot be reverted.\n";

        return false;
    }
    */
}
