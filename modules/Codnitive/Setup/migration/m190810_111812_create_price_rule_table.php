<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%price_rule}}`.
 * 
 * php yii migrate/create create_price_rule_table --fields="name:string(255):notNull,product:integer:notNull:foreignKey(order),provider:string(255):notNull,start_date:date:null,end_date:date:null,priority:integer:null,scope:integer:notNull,rule:json:null,old_price_field:string(255):null,price_field:string(255):notNull,price_change_type:integer:notNull,price_change_amount:decimal(15,4):notNull,status:boolean:notNull,created_at:datetime:notNull,updated_at:datetime:null"
 * 
 */
class m190810_111812_create_price_rule_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%price_rule}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'product' => $this->integer()->notNull(),
            'provider' => $this->string(255)->notNull(),
            'start_date' => $this->date()->null(),
            'end_date' => $this->date()->null(),
            'priority' => $this->integer()->null() . ' DEFAULT 0',
            'scope' => $this->integer()->notNull(),
            'rule' => $this->json()->null(),
            'old_price_field' => $this->string(255)->null(),
            'price_field' => $this->string(255)->notNull(),
            'price_change_type' => $this->integer()->notNull(),
            'price_change_amount' => $this->decimal(15,4)->notNull(),
            'status' => $this->boolean()->notNull(),
            'created_at' => $this->datetime()->notNull() . ' DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => $this->datetime()->null() . ' ON UPDATE CURRENT_TIMESTAMP',
        ]);
        
        // creates unique index for columns `product, provider, start_date, end_date, status`
        $this->createIndex(
            '{{%idx-price_rule-product_provider_start_date_end_date_status}}',
            '{{%price_rule}}',
            ['product', 'provider', 'start_date', 'end_date', 'status']
        );

        // creates index for column `priority`
        $this->createIndex(
            '{{%idx-price_rule-priority}}',
            '{{%price_rule}}',
            'priority'
        );


        // // creates index for column `product`
        // $this->createIndex(
        //     '{{%idx-price_rule-product}}',
        //     '{{%price_rule}}',
        //     'product'
        // );

        // // creates index for column `provider`
        // $this->createIndex(
        //     '{{%idx-price_rule-provider}}',
        //     '{{%price_rule}}',
        //     'provider'
        // );

        // // creates index for column `start_date`
        // $this->createIndex(
        //     '{{%idx-price_rule-start_date}}',
        //     '{{%price_rule}}',
        //     'start_date'
        // );

        // // creates index for column `end_date`
        // $this->createIndex(
        //     '{{%idx-price_rule-end_date}}',
        //     '{{%price_rule}}',
        //     'end_date'
        // );

        // // creates index for column `status`
        // $this->createIndex(
        //     '{{%idx-price_rule-status}}',
        //     '{{%price_rule}}',
        //     'status'
        // );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // // drops index for column `status`
        // $this->dropIndex(
        //     '{{%idx-price_rule-status}}',
        //     '{{%price_rule}}'
        // );
        
        // // drops index for column `end_date`
        // $this->dropIndex(
        //     '{{%idx-price_rule-end_date}}',
        //     '{{%price_rule}}'
        // );
        
        // // drops index for column `start_date`
        // $this->dropIndex(
        //     '{{%idx-price_rule-start_date}}',
        //     '{{%price_rule}}'
        // );
        
        // // drops index for column `provider`
        // $this->dropIndex(
        //     '{{%idx-price_rule-provider}}',
        //     '{{%price_rule}}'
        // );
        
        // // drops index for column `product`
        // $this->dropIndex(
        //     '{{%idx-price_rule-product}}',
        //     '{{%price_rule}}'
        // );


        // drops index for column `priority`
        $this->dropIndex(
            '{{%idx-price_rule-priority}}',
            '{{%price_rule}}'
        );

        // drops index for column `product`
        $this->dropIndex(
            '{{%idx-price_rule-product_provider_start_date_end_date_status}}',
            '{{%price_rule}}'
        );

        $this->dropTable('{{%price_rule}}');
    }
}
