<?php

use yii\db\Migration;

/**
 * Handles dropping wallet_transaction_id from table `saman_sep_micro_transaction`.
 * 
 * php yii migrate/create drop_wallet_transaction_id_column_from_saman_sep_micro_transaction_table --fields="wallet_transaction_id:integer:null:unique"
 * 
 */
class m190409_063951_drop_wallet_transaction_id_column_from_saman_sep_micro_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('saman_sep_micro_transaction', 'wallet_transaction_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('saman_sep_micro_transaction', 'wallet_transaction_id', $this->integer()->null()->unique());
    }
}
