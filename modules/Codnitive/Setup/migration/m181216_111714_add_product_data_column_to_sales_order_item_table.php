<?php

use yii\db\Migration;

/**
 * Handles adding product_data to table `sales_order_item`.
 * 
 * php yii migrate/create add_product_data_column_to_sales_order_item_table --fields="product_data:text"
 */
class m181216_111714_add_product_data_column_to_sales_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // $this->addColumn('sales_order_item', 'product_data', $this->text());
        $this->addColumn('sales_order_item', 'product_data', 'BLOB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('sales_order_item', 'product_data');
    }
}
