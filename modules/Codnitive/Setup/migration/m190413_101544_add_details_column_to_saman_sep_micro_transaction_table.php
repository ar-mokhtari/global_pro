<?php

use yii\db\Migration;

/**
 * Handles adding details to table `saman_sep_micro_transaction`.
 * 
 * php yii migrate/create add_details_column_to_saman_sep_micro_transaction_table --fields="details:text"
 */
class m190413_101544_add_details_column_to_saman_sep_micro_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // $this->addColumn('saman_sep_micro_transaction', 'details', $this->text());
        $this->addColumn('saman_sep_micro_transaction', 'details', 'BLOB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('saman_sep_micro_transaction', 'details');
    }
}
