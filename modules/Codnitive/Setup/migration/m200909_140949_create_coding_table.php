<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%coding}}`.
 */
class m200909_140949_create_coding_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%coding}}', [
            'id' => $this->primaryKey(),
            'code' => $this->bigInteger()->notNull(),
            'grp' => $this->integer()->notNull(),
            'parent' => $this->integer(),
            'name' => $this->string(128)->notNull(),
            'level' => $this->integer()->notNull(),
            'make_date' => $this->timestamp()->notNull()->defaultValue('CURRENT_TIMESTAMP'),
            'active' => $this->smallInteger()->notNull(),
            'user_create' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'update_at' => $this->timestamp()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP'),
            'companyID' => $this->integer()->notNull()->defaultValue(0),
        ]);
        $this->createIndex(

            'idx-unique-coding-code-grp',
            'coding',
            'code, grp',
            1
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex(
            'idx-unique-coding-code-grp',
            'coding'
        );
        $this->dropTable('{{%coding}}');
    }
}
