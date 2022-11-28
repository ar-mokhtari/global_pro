<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sections}}`.
 */
class m210104_105230_create_sections_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sections}}', [
            'id' => $this->primaryKey(),
            'companyID' => $this->integer()->notNull()->defaultValue(0),
            'yearID' => $this->integer()->notNull()->defaultValue(0),
            'firstDay' =>  $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'lastDay' =>  $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sections}}');
    }
}
