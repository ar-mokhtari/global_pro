<?php

use yii\db\Migration;

/**
 * Class m190103_070852_alter_ticket_id_ticket_number_columns_from_sales_order_item_table
 * 
 * create empty migration
 * php yii migrate/create alter_ticket_id_ticket_number_columns_from_sales_order_item_table
 */
class m190103_070852_alter_ticket_id_ticket_number_columns_from_sales_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('sales_order_item', 'ticket_id', $this->string(255));
        $this->alterColumn('sales_order_item', 'ticket_number', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('sales_order_item','ticket_number', $this->string(255));
        $this->alterColumn('sales_order_item','ticket_id', $this->integer(11));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190103_070852_alter_ticket_id_ticket_number_columns_from_sales_order_item_table cannot be reverted.\n";

        return false;
    }
    */
}
