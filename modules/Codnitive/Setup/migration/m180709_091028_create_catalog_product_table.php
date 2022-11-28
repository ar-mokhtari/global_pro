<?php

use yii\db\Migration;

/**
 * Handles the creation of table `catalog_product`.
 *
 * php yii migrate/create create_catalog_product_table --fields="name:text:notNull,price:decimal(15,4):notNull,entity_id:integer:notNull,entity_type:integer(3):notNull,entity_model:string(255):notNull,price_id:integer:notNull,price_model:string(255):notNull"
 */
class m180709_091028_create_catalog_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('catalog_product', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->notNull(),
            'price' => $this->decimal(15,4)->notNull(),
            'entity_id' => $this->integer()->notNull(),
            'entity_type' => $this->integer(3)->notNull(),
            'entity_model' => $this->string(255)->notNull(),
            'price_id' => $this->integer()->notNull(),
            'price_model' => $this->string(255)->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `entity_id`
        $this->createIndex(
            'idx-catalog_product-entity_id',
            'catalog_product',
            'entity_id'
        );

        // creates index for column `price_id`
        $this->createIndex(
            'idx-catalog_product-price_id',
            'catalog_product',
            'price_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `entity_id`
        $this->dropIndex(
            'idx-catalog_product-entity_id',
            'catalog_product'
        );

        // drops index for column `price_id`
        $this->dropIndex(
            'idx-catalog_product-price_id',
            'catalog_product'
        );

        $this->dropTable('catalog_product');
    }
}
