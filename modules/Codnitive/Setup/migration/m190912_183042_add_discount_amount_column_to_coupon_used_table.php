<?php

use yii\db\Migration;

/**
 * Handles adding discount_amount to table `{{%coupon_used}}`.
 * 
 * php yii migrate/create add_discount_amount_column_to_coupon_used_table --fields="discount_amount:decimal(15,4):notNull"
 */
class m190912_183042_add_discount_amount_column_to_coupon_used_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%coupon_used}}', 'discount_amount', $this->decimal(15,4)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%coupon_used}}', 'discount_amount');
    }
}
