<?php

use yii\db\Migration;

/**
 * Handles the creation of table `parto_hotel_property_facility`.
 * 
 * php yii migrate/create create_parto_hotel_property_facility_table --fields="property_id:integer:foreignKey(parto_hotel_property):notNull,facility_id:integer:foreignKey(parto_hotel_facility):notNull"
 * 
 * Has foreign keys to the tables:
 *
 * - `parto_hotel_property`
 * - `parto_hotel_facility`
 */
class m190703_101118_create_parto_hotel_property_facility_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parto_hotel_property_facility', [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer()->notNull(),
            'facility_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `property_id`
        $this->createIndex(
            'idx-parto_hotel_property_facility-property_id',
            'parto_hotel_property_facility',
            'property_id'
        );

        // add foreign key for table `parto_hotel_property`
        // $this->addForeignKey(
        //     'fk-parto_hotel_property_facility-property_id',
        //     'parto_hotel_property_facility',
        //     'property_id',
        //     'parto_hotel_property',
        //     'id',
        //     'CASCADE'
        // );

        // creates index for column `facility_id`
        $this->createIndex(
            'idx-parto_hotel_property_facility-facility_id',
            'parto_hotel_property_facility',
            'facility_id'
        );

        // add foreign key for table `parto_hotel_facility`
        // $this->addForeignKey(
        //     'fk-parto_hotel_property_facility-facility_id',
        //     'parto_hotel_property_facility',
        //     'facility_id',
        //     'parto_hotel_facility',
        //     'id',
        //     'CASCADE'
        // );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `parto_hotel_property`
        // $this->dropForeignKey(
        //     'fk-parto_hotel_property_facility-property_id',
        //     'parto_hotel_property_facility'
        // );

        // drops index for column `property_id`
        $this->dropIndex(
            'idx-parto_hotel_property_facility-property_id',
            'parto_hotel_property_facility'
        );

        // drops foreign key for table `parto_hotel_facility`
        // $this->dropForeignKey(
        //     'fk-parto_hotel_property_facility-facility_id',
        //     'parto_hotel_property_facility'
        // );

        // drops index for column `facility_id`
        $this->dropIndex(
            'idx-parto_hotel_property_facility-facility_id',
            'parto_hotel_property_facility'
        );

        $this->dropTable('parto_hotel_property_facility');
    }
}
