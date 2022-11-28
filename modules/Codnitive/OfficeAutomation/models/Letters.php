<?php

namespace app\modules\Codnitive\OfficeAutomation\models;

use app\modules\Codnitive\Calendar\models\Persian;

/**
 * This is the model class for table "letters".
 *
 * @property int $LettersID
 * @property string $LettersSubject
 * @property string $LettersText
 * @property string $LettersAbstract
 * @property int $LettersCreateDate
 * @property string $LettersNumber
 * @property int $LettersDraftType
 * @property int $LettersType
 * @property int $LettersTypeOfAction
 * @property int $LettersSecurity
 * @property int $LettersFollowType
 * @property int $LettersResponseType
 * @property string $LettersResponseDate
 * @property string $LettersResponseDate_Persian
 * @property int $LettersResponseID
 * @property int $LettersAttachmentType
 * @property string $LettersAttachmentUrl
 * @property string $LettersAttachmentFileName
 * @property string $LettersAttachFileExtention
 * @property int $LettersArchiveType
 * @property int $UsersID_FK
 * @property int $imageFile
 */

class Letters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $imageFile;
    public $LettersResponseDate_Persian;

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
            [['LettersSubject'], 'required'],
            [['LettersText'], 'string'],
            [['LettersDraftType', 'LettersType', 'LettersTypeOfAction', 'LettersSecurity',
                'LettersFollowType', 'LettersResponseType', 'LettersResponseID',
                'LettersAttachmentType', 'LettersArchiveType', 'UsersID_FK'], 'integer'],
            [['LettersSubject'], 'string', 'max' => 400],
            [['LettersAbstract'], 'string', 'max' => 500],
            [['LettersCreateDate', 'LettersResponseDate','LettersResponseDate_Persian'], 'string'],
            [['LettersNumber'], 'string', 'max' => 40],
            [['LettersAttachmentUrl', 'LettersAttachmentFileName'], 'string', 'max' => 200],
            ['LettersResponseDate', 'trim'],
//            ['LettersResponseType', 'required'],
//            ['LettersSecurity', 'required'],
//            ['LettersFollowType', 'required'],
//            ['LettersTypeOfAction', 'required'],
            ['LettersResponseType', 'fn_check_LettersResponseType'],
            ['imageFile', 'file'],
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
            'LettersResponseDate_Persian' => 'مهلت پاسخگویی',
            'LettersResponseID' => 'Letters Response ID',
            'LettersAttachmentType' => 'پیوست نامه',
            'LettersAttachmentUrl' => 'آدرس پیوست',
            'LettersAttachmentFileName' => 'نام فایل پیوست',
            'LettersAttachFileExtention' => ' نوع پیوست',
            'LettersArchiveType' => 'بایگانی',
            'imageFile' => 'پیوست',
            'UsersID_FK' => 'کد کاربر ثبت کننده'
        ];
    }

    public function fn_check_LettersResponseType($attribute, $params, $validation)
    {
        if ($this->LettersResponseType == '0' && $this->LettersResponseDate == '') {
            return $this->addError($attribute, 'تاریخ مهلت پاسخگویی را تعیین کنید');
        } elseif ($this->LettersResponseType === '1' && $this->LettersResponseDate !== '') {
            return $this->addError($attribute, 'تاریخ مهلت پاسخگویی بایستی خالی باشد');
        }
        return true;
    }

    public function getPersianDate()
    {
        $persian = new Persian;
        $dateParts = $persian->getDate(explode(' ', $this->LettersCreateDate)[0], false);
        $monthName = __('calendar', $persian->getMonthName($dateParts['month']));
        return "{$dateParts['day']} $monthName, {$dateParts['year']}";
    }

}
