<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sales_order`.
 * Has foreign keys to the tables:
 * 
 * php yii migrate/create create_sales_order_table --fields="customer_id:integer:notNull:foreignKey(user),status:integer(4):notNull,ticket_type:string(255),grand_total:decimal(15,4):notNull,order_date:timestamp:notNull,billing_address:text:notNull,payment_method:string(255):notNull,payment_info:text"
 *
 * - `user`
 * - `user`
 */
class m180817_063927_create_sales_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sales_order', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer()->notNull(),
            // 'merchant_id' => $this->integer()->notNull(),
            'status' => $this->integer(4)->notNull(),
            'ticket_type' => $this->string(255),
            'grand_total' => $this->decimal(15,4)->notNull(),
            'order_date' => $this->timestamp()->notNull() . ' DEFAULT CURRENT_TIMESTAMP',
            'billing_address' => $this->text()->notNull(),
            'payment_method' => $this->string(255)->notNull(),
            'payment_info' => $this->text(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `customer_id`
        $this->createIndex(
            'idx-sales_order-customer_id',
            'sales_order',
            'customer_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-sales_order-customer_id',
            'sales_order',
            'customer_id',
            'user',
            'id',
            'CASCADE'
        );

        /* // creates index for column `merchant_id`
        $this->createIndex(
            'idx-sales_order-merchant_id',
            'sales_order',
            'merchant_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-sales_order-merchant_id',
            'sales_order',
            'merchant_id',
            'user',
            'id',
            'CASCADE'
        ); */
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-sales_order-customer_id',
            'sales_order'
        );

        // drops index for column `customer_id`
        $this->dropIndex(
            'idx-sales_order-customer_id',
            'sales_order'
        );

        /* // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-sales_order-merchant_id',
            'sales_order'
        );

        // drops index for column `merchant_id`
        $this->dropIndex(
            'idx-sales_order-merchant_id',
            'sales_order'
        ); */

        $this->dropTable('sales_order');
    }
}
