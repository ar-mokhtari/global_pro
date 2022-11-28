<?php

use yii\db\Migration;

/**
 * Handles dropping billing_address from table `sales_order`.
 * 
 * php yii migrate/create drop_billing_address_column_from_sales_order_table --fields="billing_address:text:notNull"
 */
class m181216_111019_drop_billing_address_column_from_sales_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('sales_order', 'billing_address');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('sales_order', 'billing_address', $this->text()->notNull());
    }
}
