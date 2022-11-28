<?php

use yii\db\Migration;

/**
 * Class m190912_101031_add_unique_index_to_order_id_column_from_coupon_used_table
 * 
 * php yii migrate/create add_unique_index_to_order_id_column_from_coupon_used_table
 */
class m190912_101031_add_unique_index_to_order_id_column_from_coupon_used_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // creates unique index for column `order_id`
        $this->createIndex(
            'order_id',
            'coupon_used',
            'order_id',
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
            'order_id',
            'coupon_used'
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190912_101031_add_unique_index_to_order_id_column_from_coupon_used_table cannot be reverted.\n";

        return false;
    }
    */
}
