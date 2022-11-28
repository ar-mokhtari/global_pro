<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sales_order_item`.
 * Has foreign keys to the tables:
 * 
 * php yii migrate/create create_sales_order_item_table --fields="order_id:integer:notNull:foreignKey(sales_order),merchant_id:integer:notNull:foreignKey(user),name:text:notNull,price:decimal(15,4):notNull,qty:integer(11),ticket_type:string(255)"
 *
 * - `sales_order`
 * - `user`
 */
class m180819_174000_create_sales_order_item_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sales_order_item', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'merchant_id' => $this->integer()->notNull(),
            'name' => $this->text()->notNull(),
            'price' => $this->decimal(15,4)->notNull(),
            'qty' => $this->integer(11),
            'ticket_type' => $this->string(255),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `order_id`
        $this->createIndex(
            'idx-sales_order_item-order_id',
            'sales_order_item',
            'order_id'
        );

        // add foreign key for table `sales_order`
        $this->addForeignKey(
            'fk-sales_order_item-order_id',
            'sales_order_item',
            'order_id',
            'sales_order',
            'id',
            'CASCADE'
        );

        // creates index for column `merchant_id`
        $this->createIndex(
            'idx-sales_order_item-merchant_id',
            'sales_order_item',
            'merchant_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-sales_order_item-merchant_id',
            'sales_order_item',
            'merchant_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `sales_order`
        $this->dropForeignKey(
            'fk-sales_order_item-order_id',
            'sales_order_item'
        );

        // drops index for column `order_id`
        $this->dropIndex(
            'idx-sales_order_item-order_id',
            'sales_order_item'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-sales_order_item-merchant_id',
            'sales_order_item'
        );

        // drops index for column `merchant_id`
        $this->dropIndex(
            'idx-sales_order_item-merchant_id',
            'sales_order_item'
        );

        $this->dropTable('sales_order_item');
    }
}
