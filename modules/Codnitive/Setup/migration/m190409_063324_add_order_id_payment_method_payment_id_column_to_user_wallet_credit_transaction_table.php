<?php

use yii\db\Migration;

/**
 * Handles adding order_id_payment_method_payment_id to table `user_wallet_credit_transaction`.
 * Has foreign keys to the tables:
 * 
 * php yii migrate/create add_order_id_payment_method_payment_id_column_to_user_wallet_credit_transaction_table --fields="order_id:integer:null:unique:foreignKey(sales_order),payment_method:string(50):null,payment_id:integer:null"
 *
 * - `user_wallet_credit_transaction`
 */
class m190409_063324_add_order_id_payment_method_payment_id_column_to_user_wallet_credit_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_wallet_credit_transaction', 'order_id', $this->integer()->null()->unique());
        $this->addColumn('user_wallet_credit_transaction', 'payment_method', $this->string(50)->null());
        $this->addColumn('user_wallet_credit_transaction', 'payment_id', $this->integer()->null());

        // creates index for column `order_id`
        $this->createIndex(
            'idx-user_wallet_credit_transaction-order_id',
            'user_wallet_credit_transaction',
            'order_id'
        );

        // add foreign key for table `sales_order`
        $this->addForeignKey(
            'fk-user_wallet_credit_transaction-order_id',
            'user_wallet_credit_transaction',
            'order_id',
            'sales_order',
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
            'fk-user_wallet_credit_transaction-order_id',
            'user_wallet_credit_transaction'
        );

        // drops index for column `order_id`
        $this->dropIndex(
            'idx-user_wallet_credit_transaction-order_id',
            'user_wallet_credit_transaction'
        );

        $this->dropColumn('user_wallet_credit_transaction', 'order_id');
        $this->dropColumn('user_wallet_credit_transaction', 'payment_method');
        $this->dropColumn('user_wallet_credit_transaction', 'payment_id');
    }
}
