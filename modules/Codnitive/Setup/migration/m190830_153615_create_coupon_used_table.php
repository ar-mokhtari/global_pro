<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%coupon_used}}`.
 * 
 * php yii migrate/create create_coupon_used_table --fields="coupon_id:integer:notNull:foreignKey(coupon_code),order_id:integer:notNull,user_id:integer:notNull,used_at:datetime:notNull"
 * 
 * Has foreign keys to the tables:
 *
 * - `{{%coupon_code}}`
 */
class m190830_153615_create_coupon_used_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%coupon_used}}', [
            'id' => $this->primaryKey(),
            'coupon_id' => $this->integer()->notNull(),
            'order_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'used_at' => $this->datetime()->notNull() . ' DEFAULT CURRENT_TIMESTAMP',
        ]);

        // creates index for column `coupon_id`
        $this->createIndex(
            '{{%idx-coupon_used-coupon_id}}',
            '{{%coupon_used}}',
            'coupon_id'
        );

        // add foreign key for table `{{%coupon_code}}`
        $this->addForeignKey(
            '{{%fk-coupon_used-coupon_id}}',
            '{{%coupon_used}}',
            'coupon_id',
            '{{%coupon_code}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%coupon_code}}`
        $this->dropForeignKey(
            '{{%fk-coupon_used-coupon_id}}',
            '{{%coupon_used}}'
        );

        // drops index for column `coupon_id`
        $this->dropIndex(
            '{{%idx-coupon_used-coupon_id}}',
            '{{%coupon_used}}'
        );

        $this->dropTable('{{%coupon_used}}');
    }
}
