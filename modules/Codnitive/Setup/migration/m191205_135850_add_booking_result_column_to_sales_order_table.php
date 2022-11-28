<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sales_order}}`.
 * 
 * php yii migrate/create add_booking_result_column_to_sales_order_table --fields="booking_result:json"
 */
class m191205_135850_add_booking_result_column_to_sales_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sales_order}}', 'booking_result', $this->json());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sales_order}}', 'booking_result');
    }
}
