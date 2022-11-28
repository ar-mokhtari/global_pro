<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%refund_request}}`.
 * 
 * php yii migrate/create create_refund_request_table --fields="user_id:integer:notNull:foreignKey(user),item_id:integer:notNull:unique:foreignKey(sales_order_item),refund_type:integer:notNull,cancellation_reason:integer(4):notNull,cancellation_note:string(1024),status:integer(4):notNull,cancellation_penalty:decimal(15,4),refund_fee:decimal(15,4),refunded_amount:decimal(15,4),updated_by:integer:foreignKey(user),admin_comment:string(1024),wallet_transaction_id:integer:foreignKey(user_wallet_credit_transaction),created_at:datetime:notNull,updated_at:datetime"
 * 
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%sales_order_item}}`
 * - `{{%user}}`
 * - `{{%user_wallet_credit_transaction}}`
 */
class m191123_150017_create_refund_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%refund_request}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'item_id' => $this->integer()->notNull()->unique(),
            'refund_type' => $this->integer()->notNull(),
            'cancellation_reason' => $this->integer(4)->notNull(),
            'cancellation_note' => $this->string(1024),
            'status' => $this->integer(4)->notNull(),
            'cancellation_penalty' => $this->decimal(15,4),
            'refund_fee' => $this->decimal(15,4),
            'refunded_amount' => $this->decimal(15,4),
            'updated_by' => $this->integer(),
            'admin_comment' => $this->string(1024),
            'wallet_transaction_id' => $this->integer(),
            'created_at' => $this->datetime()->notNull() . ' DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => $this->datetime() . ' ON UPDATE CURRENT_TIMESTAMP',
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-refund_request-user_id}}',
            '{{%refund_request}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-refund_request-user_id}}',
            '{{%refund_request}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `item_id`
        $this->createIndex(
            '{{%idx-refund_request-item_id}}',
            '{{%refund_request}}',
            'item_id'
        );

        // add foreign key for table `{{%sales_order_item}}`
        $this->addForeignKey(
            '{{%fk-refund_request-item_id}}',
            '{{%refund_request}}',
            'item_id',
            '{{%sales_order_item}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-refund_request-updated_by}}',
            '{{%refund_request}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-refund_request-updated_by}}',
            '{{%refund_request}}',
            'updated_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `wallet_transaction_id`
        $this->createIndex(
            '{{%idx-refund_request-wallet_transaction_id}}',
            '{{%refund_request}}',
            'wallet_transaction_id'
        );

        // add foreign key for table `{{%user_wallet_credit_transaction}}`
        $this->addForeignKey(
            '{{%fk-refund_request-wallet_transaction_id}}',
            '{{%refund_request}}',
            'wallet_transaction_id',
            '{{%user_wallet_credit_transaction}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-refund_request-user_id}}',
            '{{%refund_request}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-refund_request-user_id}}',
            '{{%refund_request}}'
        );

        // drops foreign key for table `{{%sales_order_item}}`
        $this->dropForeignKey(
            '{{%fk-refund_request-item_id}}',
            '{{%refund_request}}'
        );

        // drops index for column `item_id`
        $this->dropIndex(
            '{{%idx-refund_request-item_id}}',
            '{{%refund_request}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-refund_request-updated_by}}',
            '{{%refund_request}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-refund_request-updated_by}}',
            '{{%refund_request}}'
        );

        // drops foreign key for table `{{%user_wallet_credit_transaction}}`
        $this->dropForeignKey(
            '{{%fk-refund_request-wallet_transaction_id}}',
            '{{%refund_request}}'
        );

        // drops index for column `wallet_transaction_id`
        $this->dropIndex(
            '{{%idx-refund_request-wallet_transaction_id}}',
            '{{%refund_request}}'
        );

        $this->dropTable('{{%refund_request}}');
    }
}
