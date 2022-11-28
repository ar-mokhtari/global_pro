<?php

use yii\db\Migration;

/**
 * Class m191219_150458_alter_user_table_add_credit_column_default_value
 * 
 * php yii migrate/create alter_user_table_add_credit_column_default_value
 */
class m191219_150458_alter_user_table_add_credit_column_default_value extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // alter user table credit_amount column to have default zero value
        $this->execute('ALTER TABLE user ALTER COLUMN credit_amount SET DEFAULT 0.0');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // alter user table to remove default value for credit_amount column
        $this->execute('ALTER TABLE user ALTER COLUMN credit_amount DROP DEFAULT');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191219_150458_alter_user_table_add_credit_column_default_value cannot be reverted.\n";

        return false;
    }
    */
}
