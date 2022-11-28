<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%coupon_rule}}`.
 * 
 * php yii migrate/create create_coupon_rule_table --fields="name:string(255):notNull,status:boolean:notNull,use_per_coupon:integer:null,use_per_customer:integer:null,from_date:date:null,to_date:date:null,auto_generation:boolean:notNull,product:json:null,discount_type:integer:notNull,discount_amount:decimal(15,4):notNull,max_discount:decimal(15,4):null,min_order:decimal(15,4):null,created_at:datetime:notNull,updated_at:datetime:null"
 * 
 */
class m190830_144710_create_coupon_rule_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%coupon_rule}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            // 'description' => $this->string(1024)->null(), // ,description:string(1024):null
            'status' => $this->boolean()->notNull(),
            'use_per_coupon' => $this->integer()->null(),
            'use_per_customer' => $this->integer()->null(),
            'from_date' => $this->date()->null(),
            'to_date' => $this->date()->null(),
            'auto_generation' => $this->boolean()->notNull() . ' DEFAULT 0',
            'product' => $this->json()->null(),
            'discount_type' => $this->integer()->notNull(),
            'discount_amount' => $this->decimal(15,4)->notNull(),
            'max_discount' => $this->decimal(15,4)->null(),
            'min_order' => $this->decimal(15,4)->null(),
            'created_at' => $this->datetime()->notNull() . ' DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => $this->datetime()->null() . ' ON UPDATE CURRENT_TIMESTAMP',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%coupon_rule}}');
    }
}
