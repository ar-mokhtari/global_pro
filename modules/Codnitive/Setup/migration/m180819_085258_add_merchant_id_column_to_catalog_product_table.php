<?php

use yii\db\Migration;

/**
 * Handles adding merchant_id to table `catalog_product`.
 * Has foreign keys to the tables:
 * 
 * php yii migrate/create add_merchant_id_column_to_catalog_product_table --fields="merchant_id:integer:notNull:foreignKey(user)"
 *
 * - `user`
 */
class m180819_085258_add_merchant_id_column_to_catalog_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('catalog_product', 'merchant_id', $this->integer()->notNull());

        // creates index for column `merchant_id`
        $this->createIndex(
            'idx-catalog_product-merchant_id',
            'catalog_product',
            'merchant_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-catalog_product-merchant_id',
            'catalog_product',
            'merchant_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-catalog_product-merchant_id',
            'catalog_product'
        );

        // drops index for column `merchant_id`
        $this->dropIndex(
            'idx-catalog_product-merchant_id',
            'catalog_product'
        );

        $this->dropColumn('catalog_product', 'merchant_id');
    }
}
