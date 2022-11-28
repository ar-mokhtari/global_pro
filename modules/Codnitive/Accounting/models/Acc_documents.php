<?php

namespace app\modules\Codnitive\Accounting\models;

use app\modules\Codnitive\centralOffice\models\coding\Coding;
use Yii;

/**
 * This is the model class for table "{{%acc_documents}}".
 *
 * @property int $id
 * @property int $doc_id
 * @property int $TopicCode
 * @property int $DetailCode
 * @property int $CTopicCode1
 * @property int $CTopicCode2
 * @property int $CTopicCode3
 * @property string $Comment
 * @property int $Debit
 * @property int $Credit
 *
 * @property Coding $cTopicCode1
 * @property Coding $cTopicCode2
 * @property Coding $cTopicCode3
 * @property Coding $detailCode0
 * @property Coding $topicCode
 * @property AccDocs $doc
 */
class Acc_documents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%acc_documents}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doc_id', 'TopicCode'], 'required'],
            [['doc_id', 'TopicCode', 'DetailCode', 'CTopicCode1', 'CTopicCode2', 'CTopicCode3', 'Debit', 'Credit'], 'integer'],
            [['Comment'], 'string', 'max' => 5000],
            [['CTopicCode1'], 'exist', 'skipOnError' => true, 'targetClass' => Coding::className(), 'targetAttribute' => ['CTopicCode1' => 'code']],
            [['CTopicCode2'], 'exist', 'skipOnError' => true, 'targetClass' => Coding::className(), 'targetAttribute' => ['CTopicCode2' => 'code']],
            [['CTopicCode3'], 'exist', 'skipOnError' => true, 'targetClass' => Coding::className(), 'targetAttribute' => ['CTopicCode3' => 'code']],
            [['DetailCode'], 'exist', 'skipOnError' => true, 'targetClass' => Coding::className(), 'targetAttribute' => ['DetailCode' => 'code']],
            [['TopicCode'], 'exist', 'skipOnError' => true, 'targetClass' => Coding::className(), 'targetAttribute' => ['TopicCode' => 'code']],
            [['doc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccDocs::className(), 'targetAttribute' => ['doc_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('accounting', 'ID'),
            'doc_id' => Yii::t('accounting', 'doc_id'),
            'TopicCode' => Yii::t('accounting', 'TopicCode'),
            'DetailCode' => Yii::t('accounting', 'DetailCode'),
            'CTopicCode1' => Yii::t('accounting', 'CTopicCode1'),
            'CTopicCode2' => Yii::t('accounting', 'CTopicCode2'),
            'CTopicCode3' => Yii::t('accounting', 'CTopicCode3'),
            'Comment' => Yii::t('accounting', 'Comment'),
            'Debit' => Yii::t('accounting', 'Debit'),
            'Credit' => Yii::t('accounting', 'Credit'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCTopicCode1()
    {
        return $this->hasOne(Coding::className(), ['code' => 'CTopicCode1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCTopicCode2()
    {
        return $this->hasOne(Coding::className(), ['code' => 'CTopicCode2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCTopicCode3()
    {
        return $this->hasOne(Coding::className(), ['code' => 'CTopicCode3']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetailCode0()
    {
        return $this->hasOne(Coding::className(), ['code' => 'DetailCode']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopicCode()
    {
        return $this->hasOne(Coding::className(), ['code' => 'TopicCode']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoc()
    {
        return $this->hasOne(AccDocs::className(), ['id' => 'doc_id']);
    }
}
