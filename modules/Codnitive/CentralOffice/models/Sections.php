<?php

namespace app\modules\Codnitive\CentralOffice\models;

/**
 * This is the model class for table "sections".
 *
 * @property int $companyID
 * @property int $yearID
 * @property int $firstDay
 * @property int $lastDay
 */
class Sections extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'sections';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['companyID', 'yearID', 'firstDay', 'lastDay',], 'required'],
            [['companyID', 'yearID',], 'integer'],
            [['firstDay', 'lastDay',], 'string', 'max' => 19],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'companyID' => __('account', 'companyID'),
            'yearID' => __('account', 'yearID'),
            'firstDay' => __('account', 'firstDay'),
            'lastDay' => __('account', 'lastDay'),
        ];
    }
}
