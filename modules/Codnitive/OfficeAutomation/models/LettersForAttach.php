<?php

namespace app\modules\Codnitive\OfficeAutomation\models;

/**
 * @property string $LettersAttachmentUrl
 * @property int $imageFile
 * @property int $LettersAttachmentType
 * @property int $LettersAttachmentFileName
 * @property int $LettersAttachFileExtention
 */

class LettersForAttach extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oas_letters';
    }

    public function rules()
    {
        return [
            [['imageFile'], 'required', 'message' => 'فایل پیوست انتخاب نشده است'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'imageFile' => 'پیوست',
            'LettersAttachmentType' => 'پیوست نامه',
        ];
    }

}