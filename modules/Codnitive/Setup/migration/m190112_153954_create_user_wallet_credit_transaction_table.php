<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_wallet_credit_transaction`.
 * Has foreign keys to the tables:
 * 
 * php yii migrate/create create_user_wallet_credit_transaction_table --fields="user_id:integer:notNull:foreignKey(user),change_amount:decimal(15,4):notNull,new_amount:decimal(15,4):null,description:string(512):null,trasaction_date:timestamp:notNull"
 *
 * - `user`
 */
class m190112_153954_create_user_wallet_credit_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_wallet_credit_transaction', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'change_amount' => $this->decimal(15,4)->notNull(),
            'new_amount' => $this->decimal(15,4)->null(),
            'description' => $this->string(512)->null(),
            'trasaction_date' => $this->timestamp()->notNull() . ' DEFAULT CURRENT_TIMESTAMP',
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `user_id`
        $this->createIndex(
            'idx-user_wallet_credit_transaction-user_id',
            'user_wallet_credit_transaction',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-user_wallet_credit_transaction-user_id',
            'user_wallet_credit_transaction',
            'user_id',
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
            'fk-user_wallet_credit_transaction-user_id',
            'user_wallet_credit_transaction'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-user_wallet_credit_transaction-user_id',
            'user_wallet_credit_transaction'
        );

        $this->dropTable('user_wallet_credit_transaction');
    }
}
