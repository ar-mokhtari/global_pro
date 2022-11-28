<?php

use yii\db\Migration;

/**
 * Handles adding billing_data to table `sales_order`.
 * 
 * php yii migrate/create add_billing_data_column_to_sales_order_table --fields="billing_data:text:notNull"
 */
class m181216_111148_add_billing_data_column_to_sales_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // $this->addColumn('sales_order', 'billing_data', $this->text()->notNull());
        $this->addColumn('sales_order', 'billing_data', 'BLOB NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('sales_order', 'billing_data');
    }
}
