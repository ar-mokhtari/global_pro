<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%acc_documents}}`.
 */
class m200927_075008_create_acc_documents_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%acc_documents}}', [
            'id' => $this->primaryKey(),
            'doc_id' => $this->integer()->notNull(),
            'TopicCode' => $this->bigInteger()->notNull(),
            'DetailCode' => $this->bigInteger(),
            'CTopicCode1' => $this->bigInteger(),
            'CTopicCode2' => $this->bigInteger(),
            'CTopicCode3' => $this->bigInteger(),
            'Comment' => $this->string(5000),
            'Debit' => $this->bigInteger()->notNull()->defaultValue(0),
            'Credit' => $this->bigInteger()->notNull()->defaultValue(0),
        ]);
        // creates index for column `doc_id`
        $this->createIndex(
            'idx-documents-doc_id',
            'acc_documents',
            'doc_id'
        );
        // add foreign key for table `doc`
        $this->addForeignKey(
            'fk-documents-doc_id',
            'acc_documents',
            'doc_id',
            'acc_docs',
            'id',
            'CASCADE',
            'CASCADE'
        );
        // add foreign key for table `coding` TopicCode
        $this->addForeignKey(
            'fk-documents-TopicCode',
            'acc_documents',
            'TopicCode',
            'coding',
            'code',
            'RESTRICT',
            'CASCADE'
        );
        // add foreign key for table `coding` DetailCode
        $this->addForeignKey(
            'fk-documents-DetailCode',
            'acc_documents',
            'DetailCode',
            'coding',
            'code',
            'RESTRICT',
            'CASCADE'
        );
        // add foreign key for table `coding` CTopicCode1
        $this->addForeignKey(
            'fk-documents-CTopicCode1',
            'acc_documents',
            'CTopicCode1',
            'coding',
            'code',
            'RESTRICT',
            'CASCADE'
        );
        // add foreign key for table `coding` CTopicCode2
        $this->addForeignKey(
            'fk-documents-CTopicCode2',
            'acc_documents',
            'CTopicCode2',
            'coding',
            'code',
            'RESTRICT',
            'CASCADE'
        );
        // add foreign key for table `coding` CTopicCode3
        $this->addForeignKey(
            'fk-documents-CTopicCode3',
            'acc_documents',
            'CTopicCode3',
            'coding',
            'code',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `docs`
        $this->dropForeignKey(
            'fk-documents-doc_id',
            'acc_documents'
        );
        // drops index for column `doc_id`
        $this->dropIndex(
            'idx-documents-doc_id',
            'acc_documents'
        );
        // drops index for column `TopicCode`
        $this->dropIndex(
            'fk-documents-TopicCode',
            'acc_documents'
        );
        // drops index for column `DetailCode`
        $this->dropIndex(
            'fk--documents-DetailCode',
            'acc_documents'
        );
        // drops index for column `CTopicCode1`
        $this->dropIndex(
            'fk-documents-CTopicCode1',
            'acc_documents'
        );
        // drops index for column `CTopicCode2`
        $this->dropIndex(
            'fk-documents-CTopicCode2',
            'acc_documents'
        );
        // drops index for column `CTopicCode3`
        $this->dropIndex(
            'fk-documents-CTopicCode3',
            'acc_documents'
        );
        $this->dropTable('{{%acc_documents}}');
    }
}
