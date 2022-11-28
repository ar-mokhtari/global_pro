<?php

use yii\db\Migration;

/**
 * Handles adding wallet_transaction_id to table `saman_sep_micro_transaction`.
 * 
 * php yii migrate/create add_wallet_transaction_id_column_to_saman_sep_micro_transaction_table --fields="wallet_transaction_id:integer:null:unique"
 */
class m190121_103033_add_wallet_transaction_id_column_to_saman_sep_micro_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('saman_sep_micro_transaction', 'wallet_transaction_id', $this->integer()->null()->unique());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('saman_sep_micro_transaction', 'wallet_transaction_id');
    }
}
