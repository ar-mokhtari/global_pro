<?php

use yii\db\Migration;

/**
 * Class m190121_101715_alter_order_id_columns_from_saman_sep_micro_transaction_table
 * 
 * php yii migrate/create alter_order_id_columns_from_saman_sep_micro_transaction_table
 */
class m190121_101715_alter_order_id_columns_from_saman_sep_micro_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('saman_sep_micro_transaction', 'order_id', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('saman_sep_micro_transaction', 'order_id', $this->integer()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190121_101715_alter_order_id_columns_from_saman_sep_micro_transaction_table cannot be reverted.\n";

        return false;
    }
    */
}
