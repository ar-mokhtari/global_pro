<?php

use yii\db\Migration;

/**
 * Handles the creation of table `parto_hotel_property_city`.
 * 
 * php yii migrate/create create_parto_hotel_property_city_table --fields="name:string(512):notNull,property_destination_id:integer:foreignKey(parto_hotel_property_destination):notNull"
 * 
 * Has foreign keys to the tables:
 *
 * - `parto_hotel_property_destination`
 */
class m190703_093509_create_parto_hotel_property_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parto_hotel_property_city', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
            'property_destination_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `property_destination_id`
        $this->createIndex(
            'idx-parto_hotel_property_city-property_destination_id',
            'parto_hotel_property_city',
            'property_destination_id'
        );

        // add foreign key for table `parto_hotel_property_destination`
        $this->addForeignKey(
            'fk-parto_hotel_property_city-property_destination_id',
            'parto_hotel_property_city',
            'property_destination_id',
            'parto_hotel_property_destination',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `parto_hotel_property_destination`
        $this->dropForeignKey(
            'fk-parto_hotel_property_city-property_destination_id',
            'parto_hotel_property_city'
        );

        // drops index for column `property_destination_id`
        $this->dropIndex(
            'idx-parto_hotel_property_city-property_destination_id',
            'parto_hotel_property_city'
        );

        $this->dropTable('parto_hotel_property_city');
    }
}
