<?php

use yii\db\Migration;

/**
 * Handles the creation of table `parto_hotel_property_destination`.
 * 
 * php yii migrate/create create_parto_hotel_property_destination_table --fields="name:string(512):notNull,country_code:string(3):notNull"
 * 
 * Has foreign keys to the tables:
 *
 * - `country`
 */
class m190703_091411_create_parto_hotel_property_destination_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parto_hotel_property_destination', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
            'country_code' => $this->string(3)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('parto_hotel_property_destination');
    }
}
