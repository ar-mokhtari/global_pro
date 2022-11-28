<?php

use yii\db\Migration;

/**
 * Class m191225_125545_add_unique_indices_to_passenger_book_table
 */
class m191225_125545_add_unique_indices_to_passenger_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // drops index for column `user_id, national_id`
        $this->dropIndex(
            '{{%idx-passenger_book-user_id_national_id}}',
            '{{%passenger_book}}'
        );

        // creates unique index for columns `user_id, firstname, lastname, national_id`
        $this->createIndex(
            '{{%idx-passenger_book-user_id_firstname_lastname_national_id}}',
            '{{%passenger_book}}',
            ['user_id', 'firstname', 'lastname', 'national_id'],
            true
        );

        // creates unique index for columns `user_id, firstname, lastname, passport_no`
        $this->createIndex(
            '{{%idx-passenger_book-user_id_firstname_lastname_passport_no}}',
            '{{%passenger_book}}',
            ['user_id', 'firstname', 'lastname', 'passport_no'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops index for column `user_id, firstname, lastname, passport_no`
        $this->dropIndex(
            '{{%idx-passenger_book-user_id_firstname_lastname_passport_no}}',
            '{{%passenger_book}}'
        );

        // drops index for column `user_id, firstname, lastname, national_id`
        $this->dropIndex(
            '{{%idx-passenger_book-user_id_firstname_lastname_national_id}}',
            '{{%passenger_book}}'
        );

        // creates unique index for columns `user_id, national_id`
        $this->createIndex(
            '{{%idx-passenger_book-user_id_national_id}}',
            '{{%passenger_book}}',
            ['user_id', 'national_id'],
            true
        );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191225_110008_add_unique_index_from_user_id_passport_no_to_passenger_book_table cannot be reverted.\n";

        return false;
    }
    */
}
