<?php

use yii\db\Migration;

/**
 * Handles adding credit_amount to table `user`.
 * 
 * php yii migrate/create add_credit_amount_column_to_user_table --fields="credit_amount:decimal(15,4)"
 */
class m190112_152928_add_credit_amount_column_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user', 'credit_amount', $this->decimal(15,4));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'credit_amount');
    }
}
