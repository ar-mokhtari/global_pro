<?php

use yii\db\Migration;

/**
 * Handles adding verifiaction_result to table `saman_sep_micro_transaction`.
 * 
 * php yii migrate/create add_verifiaction_result_column_to_saman_sep_micro_transaction_table --fields="verifiaction_result:decimal(15,4)"
 */
class m181226_103011_add_verifiaction_result_column_to_saman_sep_micro_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('saman_sep_micro_transaction', 'verifiaction_result', $this->decimal(15,4));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('saman_sep_micro_transaction', 'verifiaction_result');
    }
}
