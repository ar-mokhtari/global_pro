<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_bearer_token}}`.
 * 
 * php yii migrate/create create_user_bearer_token_table --fields="user_id:integer:notNull:foreignKey(user),token:char(128):notNull:unique,updated_at:datetime"
 * 
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m191218_184646_create_user_bearer_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_bearer_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'token' => $this->char(128)->notNull()->unique(),
            'updated_at' => $this->datetime() . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_bearer_token-user_id}}',
            '{{%user_bearer_token}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_bearer_token-user_id}}',
            '{{%user_bearer_token}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `token`
        $this->createIndex(
            '{{%idx-user_bearer_token-token}}',
            '{{%user_bearer_token}}',
            'token'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `token`
        $this->dropIndex(
            '{{%idx-user_bearer_token-token}}',
            '{{%user_bearer_token}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_bearer_token-user_id}}',
            '{{%user_bearer_token}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_bearer_token-user_id}}',
            '{{%user_bearer_token}}'
        );

        $this->dropTable('{{%user_bearer_token}}');
    }
}
