<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%passenger_book}}`.
 * 
 * php yii migrate/create create_passenger_book_table --fields="user_id:integer:notNull:foreignKey(user),firstname:string(128),lastname:string(128),firstname_english:string(128),lastname_english:string(128),national_id:bigInteger(10),birth_date:date,gender:boolean,cellphone:char(14),email:string(255),birth_country:string(3),passport_no:string(128),passport_country:string(3),passport_expiration_date:date,created_at:datetime:notNull,updated_at:datetime"
 * 
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m191004_215830_create_passenger_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%passenger_book}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'firstname' => $this->string(128),
            'lastname' => $this->string(128),
            'firstname_english' => $this->string(128),
            'lastname_english' => $this->string(128),
            'national_id' => $this->bigInteger(10),
            'birth_date' => $this->date(),
            'gender' => $this->boolean(),
            'cellphone' => $this->char(14),
            'email' => $this->string(255),
            'birth_country' => $this->string(3),
            'passport_no' => $this->string(128),
            'passport_country' => $this->string(3),
            'passport_expiration_date' => $this->date(),
            'created_at' => $this->datetime()->notNull() . ' DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => $this->datetime() . ' ON UPDATE CURRENT_TIMESTAMP',
        ]);

        // creates unique index for columns `user_id, national_id`
        $this->createIndex(
            '{{%idx-passenger_book-user_id_national_id}}',
            '{{%passenger_book}}',
            ['user_id', 'national_id'],
            true
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-passenger_book-user_id}}',
            '{{%passenger_book}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-passenger_book-user_id}}',
            '{{%passenger_book}}',
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
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-passenger_book-user_id}}',
            '{{%passenger_book}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-passenger_book-user_id}}',
            '{{%passenger_book}}'
        );

        // drops index for column `user_id, national_id`
        $this->dropIndex(
            '{{%idx-passenger_book-user_id_national_id}}',
            '{{%passenger_book}}'
        );

        $this->dropTable('{{%passenger_book}}');
    }
}
