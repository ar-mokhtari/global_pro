<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%coding_relation}}`.
 */
class m201209_072556_create_coding_relation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%coding_relation}}', [
            'id' => $this->primaryKey(),
            'first_code' => $this->Integer()->notNull(),
            'second_code' => $this->Integer()->notNull(),
            'create_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->createIndex(
            'idx-unique-coding_relation-first_second_code',
            'coding_relation',
            'first_code, second_code',
            1
        );
        $this->createIndex(
            'idx-coding_relation-id',
            'coding_relation',
            'first_code'
        );
        $this->addForeignKey(
            'fk-coding_relation-fid',
            'coding_relation',
            'first_code',
            'coding',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-coding_relation-sid',
            'coding_relation',
            'second_code',
            'coding',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'fk-coding_relation-sid',
            'coding_relation'
        );
        $this->dropIndex(
            'fk-coding_relation-fid',
            'coding_relation'
        );
        $this->dropIndex(
            'idx-unique-coding_relation-first_second_code',
            'coding_relation'
        );
        $this->dropIndex(
            'idx-coding_relation-id',
            'coding_relation'
        );
        $this->dropTable('{{%coding_relation}}');
    }
}
