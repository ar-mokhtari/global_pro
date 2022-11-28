<?php

use yii\db\Migration;

/**
 * Handles the creation of table `saman_sep_micro_transaction`.
 * Has foreign keys to the tables:
 * 
 * php yii migrate/create create_saman_sep_micro_transaction_table --fields="order_id:integer:notNull:unique:foreignKey(sales_order),state_code:integer(5):notNull,state:string(255):notNull,ref_num:string(50):null:unique,trance_no:integer:null"
 *
 * - `saman_sep_micro_transaction`
 */
class m181225_124437_create_saman_sep_micro_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('saman_sep_micro_transaction', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull()->unique(),
            'state_code' => $this->integer(5)->notNull(),
            'state' => $this->string(255)->notNull(),
            'ref_num' => $this->string(50)->null()->unique(),
            'trance_no' => $this->integer()->null(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `order_id`
        $this->createIndex(
            'idx-saman_sep_micro_transaction-order_id',
            'saman_sep_micro_transaction',
            'order_id'
        );

        // add foreign key for table `sales_order`
        $this->addForeignKey(
            'fk-saman_sep_micro_transaction-order_id',
            'saman_sep_micro_transaction',
            'order_id',
            'sales_order',
            'id',
            'CASCADE'
        );

        // creates index for column `ref_num`
        $this->createIndex(
            'idx-saman_sep_micro_transaction-ref_num',
            'saman_sep_micro_transaction',
            'ref_num'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `ref_num`
        $this->dropIndex(
            'idx-saman_sep_micro_transaction-ref_num',
            'saman_sep_micro_transaction'
        );

        // drops foreign key for table `sales_order`
        $this->dropForeignKey(
            'fk-saman_sep_micro_transaction-order_id',
            'saman_sep_micro_transaction'
        );

        // drops index for column `order_id`
        $this->dropIndex(
            'idx-saman_sep_micro_transaction-order_id',
            'saman_sep_micro_transaction'
        );

        $this->dropTable('saman_sep_micro_transaction');
    }
}
