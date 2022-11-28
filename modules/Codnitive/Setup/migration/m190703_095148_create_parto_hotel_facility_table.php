<?php

use yii\db\Migration;

/**
 * Handles the creation of table `parto_hotel_facility`.
 * 
 * php yii migrate/create create_parto_hotel_facility_table --fields="facility_group_id:integer:foreignKey(parto_hotel_facility_group):notNull,name:string(512):notNull"
 * 
 * Has foreign keys to the tables:
 *
 * - `parto_hotel_facility_group`
 */
class m190703_095148_create_parto_hotel_facility_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parto_hotel_facility', [
            'id' => $this->primaryKey(),
            'facility_group_id' => $this->integer()->notNull(),
            'name' => $this->string(512)->notNull(),
        ]);

        // creates index for column `facility_group_id`
        $this->createIndex(
            'idx-parto_hotel_facility-facility_group_id',
            'parto_hotel_facility',
            'facility_group_id'
        );

        // add foreign key for table `parto_hotel_facility_group`
        $this->addForeignKey(
            'fk-parto_hotel_facility-facility_group_id',
            'parto_hotel_facility',
            'facility_group_id',
            'parto_hotel_facility_group',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `parto_hotel_facility_group`
        $this->dropForeignKey(
            'fk-parto_hotel_facility-facility_group_id',
            'parto_hotel_facility'
        );

        // drops index for column `facility_group_id`
        $this->dropIndex(
            'idx-parto_hotel_facility-facility_group_id',
            'parto_hotel_facility'
        );

        $this->dropTable('parto_hotel_facility');
    }
}
