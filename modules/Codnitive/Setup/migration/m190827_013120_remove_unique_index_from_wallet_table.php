<?php

use yii\db\Migration;

/**
 * Class m190827_013120_remove_unique_index_from_wallet_table
 */
class m190827_013120_remove_unique_index_from_wallet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // drops unique index for column `order_id`
        $this->dropIndex(
            'order_id',
            'user_wallet_credit_transaction'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // creates unique index for column `order_id`
        $this->createIndex(
            'order_id',
            'user_wallet_credit_transaction',
            'order_id',
            true
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190827_013120_remove_unique_index_from_wallet_table cannot be reverted.\n";

        return false;
    }
    */
}
