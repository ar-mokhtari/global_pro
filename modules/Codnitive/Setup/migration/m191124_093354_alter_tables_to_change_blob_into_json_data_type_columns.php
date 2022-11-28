<?php

use yii\db\Migration;

/**
 * Class m191124_093354_alter_tables_to_change_blob_into_json_data_type_columns
 */
class m191124_093354_alter_tables_to_change_blob_into_json_data_type_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // alter billing_data column from sales_order table to change it into json data type
        $this->alterColumn('sales_order', 'billing_data', 'LONGTEXT');
        $this->alterColumn('sales_order', 'billing_data', $this->json());

        // alter product_data column from sales_order_item table to change it into json data type
        $this->alterColumn('sales_order_item', 'product_data', 'LONGTEXT');
        $this->alterColumn('sales_order_item', 'product_data', $this->json());

        // alter details column from saman_sep_micro_transaction table to change it into json data type
        $this->alterColumn('saman_sep_micro_transaction', 'details', 'LONGTEXT');
        $this->alterColumn('saman_sep_micro_transaction', 'details', $this->json());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // alter billing_data column from sales_order table to return it into blob data type
        $this->alterColumn('sales_order', 'billing_data', 'BLOB NOT NULL');

        // alter product_data column from sales_order_item table to return it into blob data type
        $this->alterColumn('sales_order_item', 'product_data', 'BLOB');

        // alter details column from saman_sep_micro_transaction table to return it into blob data type
        $this->alterColumn('saman_sep_micro_transaction', 'details', 'BLOB');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191124_093354_alter_tables_to_change_blob_into_json_data_type_columns cannot be reverted.\n";

        return false;
    }
    */
}
