<?php

use yii\db\Migration;

/**
 * Handles adding ticket_info_columns to table `sales_order_item`.
 * 
 * php yii migrate/create add_ticket_info_columns_column_to_sales_order_item_table --fields="ticket_provider:string(255),ticket_id:integer(11),ticket_number:string(255),ticket_status:integer(5)"
 */
class m181229_172901_add_ticket_info_columns_column_to_sales_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('sales_order_item', 'ticket_provider', $this->string(255));
        $this->addColumn('sales_order_item', 'ticket_id', $this->integer(11));
        $this->addColumn('sales_order_item', 'ticket_number', $this->string(255));
        $this->addColumn('sales_order_item', 'ticket_status', $this->integer(5));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('sales_order_item', 'ticket_provider');
        $this->dropColumn('sales_order_item', 'ticket_id');
        $this->dropColumn('sales_order_item', 'ticket_number');
        $this->dropColumn('sales_order_item', 'ticket_status');
    }
}
