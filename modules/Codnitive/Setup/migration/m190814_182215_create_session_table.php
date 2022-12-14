<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%session}}`.
 */
class m190814_182215_create_session_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%session}}', [
            'id' => $this->char(40)->notNull(),
            'expire' => $this->integer(),
            'data' => $this->binary(),
        ]);
        $this->addPrimaryKey('session_pk', 'session', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%session}}');
    }
}
