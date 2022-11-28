<?php

use yii\db\Migration;

/**
 * Handles the creation of table `parto_hotel_chain`.
 * 
 * php yii migrate/create create_parto_hotel_chain_table --fields="name:string(512):notNull"
 * 
 */
class m190702_131359_create_parto_hotel_chain_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('parto_hotel_chain', [
            'id' => $this->primaryKey(),
            'name' => $this->string(512)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('parto_hotel_chain');
    }
}
