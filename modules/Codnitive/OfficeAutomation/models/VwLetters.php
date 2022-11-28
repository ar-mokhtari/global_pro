<?php

namespace app\modules\Codnitive\OfficeAutomation\models;

use app\modules\Codnitive\Core\models\ActiveRecord;

/**
 * This is the model class for table "vw_letters".
 *
 * @property int $LettersID
 * @property string $LettersSubject
 * @property string $LettersText
 * @property string $LettersAbstract
 * @property string $LettersCreateDate
 * @property string $LettersNumber
 * @property int $LettersDraftType
 * @property int $LettersType
 * @property int $LettersTypeOfAction
 * @property int $LettersSecurity
 * @property int $LettersFollowType
 * @property int $LettersResponseType
 * @property string $LettersResponseDate
 * @property int $LettersResponseID
 * @property int $LettersAttachmentType
 * @property string $LettersAttachmentUrl
 * @property string $LettersAttachmentFileName
 * @property int $LettersArchiveType
 * @property int $UsersID_FK
 * @property string $FullName
 * @property string $PersianLettersTypeOfAction
 * @property string $PersianLettersSecurity
 * @property string $PersianLettersArchiveType
 * @property string $PersianLettersFollowType
 * @property string $PersianLettersAttachmentType
 * @property string $PersianLettersType
 * @property string $PersianLettersResponseType
 * @property string $PersianLettersDraftType
 */
class VwLetters extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function primaryKey()
    {
        return ['LettersID'];
    }

    public static function tableName()
    {
        return '{{oas_vw_letters}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LettersID', 'LettersDraftType', 'LettersType', 'LettersTypeOfAction', 'LettersSecurity', 'LettersFollowType', 'LettersResponseType', 'LettersResponseID', 'LettersAttachmentType', 'LettersArchiveType', 'UsersID_FK'], 'integer'],
            [['LettersSubject'], 'required'],
            [['LettersText'], 'string'],
            [['LettersSubject'], 'string', 'max' => 400],
            [['LettersAbstract'], 'string', 'max' => 500],
            [['LettersCreateDate', 'LettersResponseDate'], 'integer'],
            [['LettersNumber'], 'string', 'max' => 40],
            [['LettersAttachmentUrl', 'LettersAttachmentFileName'], 'string', 'max' => 200],
            [['FullName'], 'string', 'max' => 251],
            [['PersianLettersTypeOfAction'], 'string', 'max' => 4],
            [['PersianLettersSecurity', 'PersianLettersDraftType'], 'string', 'max' => 7],
            [['PersianLettersArchiveType', 'PersianLettersFollowType', 'PersianLettersType'], 'string', 'max' => 12],
            [['PersianLettersAttachmentType'], 'string', 'max' => 11],
            [['PersianLettersResponseType'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LettersID' => 'کد نامه',
            'LettersSubject' => 'موضوع نامه',
            'LettersText' => 'متن نامه',
            'LettersAbstract' => 'خلاصه نامه',
            'LettersCreateDate' => 'تاریخ ایجاد',
            'LettersNumber' => 'شماره نامه',
            'LettersDraftType' => 'طبقه نامه',
            'LettersType' => 'نوع نامه',
            'LettersTypeOfAction' => 'نوع اقدام',
            'LettersSecurity' => 'سطح امنیتی',
            'LettersFollowType' => 'پیگیری نامه',
            'LettersResponseType' => 'اولویت پاسخگویی',
            'LettersResponseDate' => 'مهلت پاسخگویی',
            'LettersResponseID' => 'Letters Response ID',
            'LettersAttachmentType' => 'پیوست نامه',
            'LettersAttachmentUrl' => 'آدرس پیوست',
            'LettersAttachmentFileName' => 'نام فایل پیوست',
            'LettersAttachFileExtention' => 'نوع پیوست',
            'LettersArchiveType' => 'بایگانی',
            'imageFile' => 'پیوست',
            'UsersID_FK' => 'کد کاربر ثبت کننده',
            'FullName' => 'کاربر ایجادکننده',
            'PersianLettersTypeOfAction' => 'نوع اقدام',
            'PersianLettersSecurity' => 'سطح دسترسی',
            'PersianLettersArchiveType' => 'بایگانی',
            'PersianLettersFollowType' => 'پیگیری',
            'PersianLettersAttachmentType' => 'پیوست',
            'PersianLettersType' => 'نوع نامه',
            'PersianLettersResponseType' => 'مهلت پاسخ',
            'PersianLettersDraftType' => 'وضعیت نامه',
        ];
    }
}