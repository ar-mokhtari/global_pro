<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%coupon_code}}`.
 * 
 * php yii migrate/create create_coupon_code_table --fields="rule_id:integer:notNull:foreignKey(coupon_rule),user_id:integer:null:foreignKey(user),coupon_code:string(64):notNull,auto_generated:boolean:notNull"
 * 
 * Has foreign keys to the tables:
 *
 * - `{{%coupon_rule}}`
 * - `{{%user}}`
 */
class m190830_152803_create_coupon_code_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%coupon_code}}', [
            'id' => $this->primaryKey(),
            'rule_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->null(),
            'coupon_code' => $this->string(64)->notNull(),
            'auto_generated' => $this->boolean()->notNull(),
        ]);

        // creates index for column `rule_id`
        $this->createIndex(
            '{{%idx-coupon_code-rule_id}}',
            '{{%coupon_code}}',
            'rule_id'
        );

        // add foreign key for table `{{%coupon_rule}}`
        $this->addForeignKey(
            '{{%fk-coupon_code-rule_id}}',
            '{{%coupon_code}}',
            'rule_id',
            '{{%coupon_rule}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-coupon_code-user_id}}',
            '{{%coupon_code}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-coupon_code-user_id}}',
            '{{%coupon_code}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%coupon_rule}}`
        $this->dropForeignKey(
            '{{%fk-coupon_code-rule_id}}',
            '{{%coupon_code}}'
        );

        // drops index for column `rule_id`
        $this->dropIndex(
            '{{%idx-coupon_code-rule_id}}',
            '{{%coupon_code}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-coupon_code-user_id}}',
            '{{%coupon_code}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-coupon_code-user_id}}',
            '{{%coupon_code}}'
        );

        $this->dropTable('{{%coupon_code}}');
    }
}
