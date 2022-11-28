<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%acc_docs}}`.
 */
class m200921_151637_create_acc_docs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%acc_docs}}', [
            'id' => $this->primaryKey(),
            'companyCode' => $this->integer()->notNull(),
            'SecondaryDocNo' => $this->integer()->notNull()->unique(),
            'PrimaryDocNo' => $this->integer()->unique(),
            'DocDate' => $this->timestamp()->notNull(),
            'DocTypeCode' => $this->tinyInteger()->notNull(),
            'Status' => $this->tinyInteger()->notNull(),
            'DocTopic' => $this->string(2500),
            'MakeDate' => $this->timestamp()->notNull()->defaultValue(date('Y-m-d')),
            'SecondDate' => $this->timestamp()->defaultValue(date('Y-m-d')),
            'DocNote' => $this->text(),
            'FirstUserID' => $this->integer()->notNull(),
            'SecondUserID' => $this->integer(),
            'YearID' =>$this->integer()->notNull(),
            'companyID' => $this->integer()->notNull()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%acc_docs}}');
    }
}
