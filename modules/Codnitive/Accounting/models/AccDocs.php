<?php

namespace app\modules\Codnitive\Accounting\models;

use Yii;

/**
 * This is the model class for table "acc_docs".
 *
 * @property int $id
 * @property int $companyCode
 * @property int $SecondaryDocNo
 * @property int $PrimaryDocNo
 * @property string $DocDate
 * @property int $DocTypeCode
 * @property int $Status
 * @property string $DocTopic
 * @property string $MakeDate
 * @property string $SecondDate
 * @property string $DocNote
 * @property int $FirstUserID
 * @property int $SecondUserID
 * @property int $YearID
 */
class AccDocs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acc_docs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['companyCode', 'SecondaryDocNo', 'DocTypeCode', 'Status', 'FirstUserID', 'YearID'], 'required'],
            [['companyCode', 'SecondaryDocNo', 'PrimaryDocNo', 'DocTypeCode', 'Status', 'FirstUserID', 'SecondUserID', 'YearID'], 'integer'],
            [['DocDate', 'MakeDate', 'SecondDate'], 'safe'],
            [['DocNote'], 'string'],
            [['DocTopic'], 'string', 'max' => 2500],
            [['SecondaryDocNo'], 'unique'],
            [['PrimaryDocNo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => __('accounting', 'ID'),
            'companyCode' => __('accounting', 'companyCode'),
            'SecondaryDocNo' => __('accounting', 'SecondaryDocNo'),
            'PrimaryDocNo' => __('accounting', 'PrimaryDocNo'),
            'DocDate' => __('accounting', 'DocDate'),
            'DocTypeCode' => __('accounting', 'DocTypeCode'),
            'Status' => __('accounting', 'Status'),
            'DocTopic' => __('accounting', 'DocTopic'),
            'MakeDate' => __('accounting', 'MakeDate'),
            'SecondDate' => __('accounting', 'SecondDate'),
            'DocNote' => __('accounting', 'DocNote'),
            'FirstUserID' => __('accounting', 'FirstUserID'),
            'SecondUserID' => __('accounting', 'Second UserID'),
            'YearID' => __('accounting', 'YearID'),
        ];
    }
}
