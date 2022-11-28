<?php

use yii\db\Migration;

/**
 * Handles dropping ticket_type from table `sales_order`.
 * 
 * php yii migrate/create drop_ticket_type_column_from_sales_order_table --fields="ticket_type:string(255)"
 * 
 */
class m180819_212046_drop_ticket_type_column_from_sales_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('sales_order', 'ticket_type');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('sales_order', 'ticket_type', $this->string(255));
    }
}
