<?php

use yii\db\Migration;

/**
 * Handles the creation of table `country`.
 * 
 * php yii migrate/create create_country_table --fields="code:string(3):notNull:unique,name:string(512):notNull"
 */
class m190703_084308_create_country_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('country', [
            'id' => $this->primaryKey(),
            'code' => $this->string(3)->notNull()->unique(),
            'name' => $this->string(512)->notNull(),
        ]);

        // creates index for column `country_code`
        $this->createIndex(
            'idx-country-code',
            'country',
            'code'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `country_code`
        $this->dropIndex(
            'idx-country-code',
            'country'
        );

        $this->dropTable('country');
    }
}
