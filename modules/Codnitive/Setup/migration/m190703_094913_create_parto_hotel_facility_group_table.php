<?php

use yii\db\Migration;

/**
 * Handles the creation of table `parto_hotel_facility_group`.
 * 
 * php yii migrate/create create_parto_hotel_facility_group_table --fields="name:string(512):notNull"
 */
class m190703_094913_create_parto_hotel_facility_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parto_hotel_facility_group', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('parto_hotel_facility_group');
    }
}
