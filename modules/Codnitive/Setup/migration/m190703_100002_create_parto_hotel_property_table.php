<?php

use yii\db\Migration;

/**
 * Handles the creation of table `parto_hotel_property`.
 * 
 * php yii migrate/create create_parto_hotel_property_table --fields="property_city_id:integer:notNull:foreignKey(parto_hotel_property_city),accommodation_id:integer:notNull:foreignKey(parto_hotel_property_accommodation),name:string(512):null,rating:integer(3):null,review_score:decimal(5,2):null,address:string(1024):null,doc:json:null"
 * 
 * Has foreign keys to the tables:
 *
 * - `parto_hotel_property_city`
 * - `parto_hotel_property_accommodation`
 */
class m190703_100002_create_parto_hotel_property_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parto_hotel_property', [
            'id' => $this->primaryKey(),
            'property_city_id' => $this->integer()->notNull(),
            'accommodation_id' => $this->integer()->notNull(),
            'name' => $this->string(512)->null(),
            'rating' => $this->integer(3)->null(),
            'review_score' => $this->decimal(5,2)->null(),
            'address' => $this->string(1024)->null(),
            'doc' => $this->json()->null(),
        ]);

        // creates index for column `property_city_id`
        $this->createIndex(
            'idx-parto_hotel_property-property_city_id',
            'parto_hotel_property',
            'property_city_id'
        );

        // add foreign key for table `parto_hotel_property_city`
        $this->addForeignKey(
            'fk-parto_hotel_property-property_city_id',
            'parto_hotel_property',
            'property_city_id',
            'parto_hotel_property_city',
            'id',
            'CASCADE'
        );

        // creates index for column `accommodation_id`
        $this->createIndex(
            'idx-parto_hotel_property-accommodation_id',
            'parto_hotel_property',
            'accommodation_id'
        );

        // add foreign key for table `parto_hotel_property_accommodation`
        $this->addForeignKey(
            'fk-parto_hotel_property-accommodation_id',
            'parto_hotel_property',
            'accommodation_id',
            'parto_hotel_property_accommodation',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `parto_hotel_property_city`
        $this->dropForeignKey(
            'fk-parto_hotel_property-property_city_id',
            'parto_hotel_property'
        );

        // drops index for column `property_city_id`
        $this->dropIndex(
            'idx-parto_hotel_property-property_city_id',
            'parto_hotel_property'
        );

        // drops foreign key for table `parto_hotel_property_accommodation`
        $this->dropForeignKey(
            'fk-parto_hotel_property-accommodation_id',
            'parto_hotel_property'
        );

        // drops index for column `accommodation_id`
        $this->dropIndex(
            'idx-parto_hotel_property-accommodation_id',
            'parto_hotel_property'
        );

        $this->dropTable('parto_hotel_property');
    }
}
