<?php

use yii\db\Migration;

/**
 * Class m190910_170821_add_unique_index_to_coupon_code_column_from_coupon_code_table
 */
class m190910_170821_add_unique_index_to_coupon_code_column_from_coupon_code_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // creates unique index for column `coupon_code`
        $this->createIndex(
            'coupon_code',
            'coupon_code',
            'coupon_code',
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops unique index for column `coupon_code`
        $this->dropIndex(
            'coupon_code',
            'coupon_code'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190910_170821_add_unique_index_to_coupon_code_column_from_coupon_code_table cannot be reverted.\n";

        return false;
    }
    */
}
