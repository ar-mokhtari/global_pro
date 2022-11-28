<?php

namespace app\modules\Codnitive\OfficeAutomation\models;

use Yii;

/**
 * This is the model class for table "letterstrash".
 *
 * @property int $LettersTrashID
 * @property int $LettersID_FK
 * @property int $UsersID_FK
 * @property string $LettersTrashDate
 */
class Letterstrash extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oas_letterstrash';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LettersID_FK', 'UsersID_FK'], 'integer'],
            [['LettersTrashDate'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LettersTrashID' => 'Letters Trash ID',
            'LettersID_FK' => 'Letters Id Fk',
            'UsersID_FK' => 'Users Id Fk',
            'LettersTrashDate' => 'Letters Trash Date',
        ];
    }
}
