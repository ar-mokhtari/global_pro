<?php

namespace app\modules\Codnitive\CentralOffice\models;

/**
 * This is the model class for table "users".
 *
 * @property int $UserID
 * @property string $UserSign
 * @property int $ImageFile
 */
class UsersSign extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $ImageFile;

    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ImageFile'], 'required'],
            ['ImageFile', 'file'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ImageFile'=>'تصویر'
        ];
    }
}
