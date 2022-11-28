<?php

use yii\db\Migration;

/**
 * Handles the creation of table `parto_hotel_property_chain`.
 * 
 * php yii migrate/create create_parto_hotel_property_chain_table --fields="property_id:integer:foreignKey(parto_hotel_property):notNull,chain_id:integer:foreignKey(parto_hotel_chain):notNull"
 * 
 * Has foreign keys to the tables:
 *
 * - `parto_hotel_property`
 * - `parto_hotel_chain`
 */
class m190703_100944_create_parto_hotel_property_chain_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parto_hotel_property_chain', [
            'id' => $this->primaryKey(),
            'property_id' => $this->integer()->notNull(),
            'chain_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `property_id`
        $this->createIndex(
            'idx-parto_hotel_property_chain-property_id',
            'parto_hotel_property_chain',
            'property_id'
        );

        // add foreign key for table `parto_hotel_property`
        // $this->addForeignKey(
        //     'fk-parto_hotel_property_chain-property_id',
        //     'parto_hotel_property_chain',
        //     'property_id',
        //     'parto_hotel_property',
        //     'id',
        //     'CASCADE'
        // );

        // creates index for column `chain_id`
        $this->createIndex(
            'idx-parto_hotel_property_chain-chain_id',
            'parto_hotel_property_chain',
            'chain_id'
        );

        // add foreign key for table `parto_hotel_chain`
        // $this->addForeignKey(
        //     'fk-parto_hotel_property_chain-chain_id',
        //     'parto_hotel_property_chain',
        //     'chain_id',
        //     'parto_hotel_chain',
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
        //     'fk-parto_hotel_property_chain-property_id',
        //     'parto_hotel_property_chain'
        // );

        // drops index for column `property_id`
        $this->dropIndex(
            'idx-parto_hotel_property_chain-property_id',
            'parto_hotel_property_chain'
        );

        // drops foreign key for table `parto_hotel_chain`
        // $this->dropForeignKey(
        //     'fk-parto_hotel_property_chain-chain_id',
        //     'parto_hotel_property_chain'
        // );

        // drops index for column `chain_id`
        $this->dropIndex(
            'idx-parto_hotel_property_chain-chain_id',
            'parto_hotel_property_chain'
        );

        $this->dropTable('parto_hotel_property_chain');
    }
}
