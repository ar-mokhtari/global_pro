<?php

use yii\db\Migration;

/**
 * Handles adding revert_state_code to table `saman_sep_micro_transaction`.
 * 
 * php yii migrate/create add_revert_state_code_column_to_saman_sep_micro_transaction_table --fields="revert_state_code:integer(4):null"
 */
class m190413_104311_add_revert_state_code_column_to_saman_sep_micro_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('saman_sep_micro_transaction', 'revert_state_code', $this->integer(4)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('saman_sep_micro_transaction', 'revert_state_code');
    }
}
