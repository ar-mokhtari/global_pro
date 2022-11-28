<?php

use yii\db\Migration;

/**
 * Handles adding coupon_code to table `{{%coupon_used}}`.
 * 
 * php yii migrate/create add_code_column_to_coupon_used_table --fields="code:string(64):notNull"
 * 
 */
class m190912_171147_add_coupon_code_column_to_coupon_used_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%coupon_used}}', 'code', $this->string(64)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%coupon_used}}', 'code');
    }
}
