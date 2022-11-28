<?php

use yii\db\Migration;

/**
 * Class m191205_142157_alter_table_sales_order_to_change_payment_info_column_into_json
 */
class m191205_142157_alter_table_sales_order_to_change_payment_info_column_into_json extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // alter payment_info column from sales_order table to change it into json data type
        $this->alterColumn('{{%sales_order}}', 'payment_info', $this->json());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // alter payment_info column from sales_order table to return it into text data type
        $this->alterColumn('{{%sales_order}}', 'payment_info', $this->text());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191205_142157_alter_table_sales_order_to_change_payment_info_column_into_json cannot be reverted.\n";

        return false;
    }
    */
}
