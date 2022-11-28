<?php

namespace app\modules\Codnitive\OfficeAutomation\models;

use Yii;

/**
 * This is the model class for table "vw_referralletters".
 *
 * @property int $ReferralLettersID
 * @property string $ReferralLettersDate
 * @property string $ReferralLettersDescription
 * @property int $LettersID_FK
 * @property int $UsersID_Sender
 * @property int $UsersID_Receiver
 * @property int $ReferralLettersReadType
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
 * @property string $LettersAttachFileExtention
 * @property int $LettersArchiveType
 * @property int $UsersID_FK
 * @property string $FullNameSender
 * @property string $FullNameReceiver
 * @property string $FullCreator
 * @property string $PersianLettersTypeOfAction
 * @property string $PersianLettersSecurity
 * @property string $PersianLettersArchiveType
 * @property string $PersianLettersFollowType
 * @property string $PersianLettersAttachmentType
 * @property string $PersianLettersType
 * @property string $PersianLettersResponseType
 * @property string $PersianLettersDraftType
 * @property string $PersianReferralLettersReadType
 */
class VwReferralletters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oas_vw_referralletters';
    }

    public static function primaryKey()
    {
        return['ReferralLettersID'];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ReferralLettersID', 'LettersID_FK', 'UsersID_Sender', 'UsersID_Receiver', 'ReferralLettersReadType', 'LettersID', 'LettersDraftType', 'LettersType', 'LettersTypeOfAction', 'LettersSecurity', 'LettersFollowType', 'LettersResponseType', 'LettersResponseID', 'LettersAttachmentType', 'LettersArchiveType', 'UsersID_FK'], 'integer'],
            [['ReferralLettersDescription', 'LettersText'], 'string'],
            [['LettersID_FK', 'UsersID_Sender', 'UsersID_Receiver', 'LettersNumber', 'LettersDraftType', 'LettersType', 'UsersID_FK'], 'required'],
            [['ReferralLettersDate', 'LettersCreateDate', 'LettersResponseDate'], 'string', 'max' => 20],
            [['LettersSubject'], 'string', 'max' => 400],
            [['LettersAbstract'], 'string', 'max' => 500],
            [['LettersNumber'], 'string', 'max' => 40],
            [['LettersAttachmentUrl', 'LettersAttachmentFileName'], 'string', 'max' => 200],
            [['LettersAttachFileExtention'], 'string', 'max' => 10],
            [['FullNameSender', 'FullNameReceiver', 'FullCreator'], 'string', 'max' => 251],
            [['PersianLettersTypeOfAction'], 'string', 'max' => 4],
            [['PersianLettersSecurity', 'PersianLettersDraftType'], 'string', 'max' => 7],
            [['PersianLettersArchiveType', 'PersianLettersFollowType', 'PersianLettersType'], 'string', 'max' => 12],
            [['PersianLettersAttachmentType', 'PersianReferralLettersReadType'], 'string', 'max' => 11],
            [['PersianLettersResponseType'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ReferralLettersID' => 'کدنامه‌ارجاع',
            'ReferralLettersDate' => 'تاریخ ارجاع',
            'ReferralLettersDescription' => 'توضیحات',
            'LettersID_FK' => 'کدنامه‌اصلی',
            'UsersID_Sender' => 'Users Id  Sender',
            'UsersID_Receiver' => 'Users Id  Receiver',
            'ReferralLettersReadType' => 'Referral Letters Read Type',
            'LettersID' => 'Letters ID',
            'LettersSubject' => 'موضوع',
            'LettersText' => 'متن نامه',
            'LettersAbstract' => 'چکیده',
            'LettersCreateDate' => 'تاریخ ایجاد',
            'LettersNumber' => 'شماره نامه',
            'LettersDraftType' => 'Letters Draft Type',
            'LettersType' => 'Letters Type',
            'LettersTypeOfAction' => 'نوع اقدام',
            'LettersSecurity' => 'سطح دسترسی',
            'LettersFollowType' => 'پیگیری',
            'LettersResponseType' => 'زمانبندی پاسخ',
            'LettersResponseDate' => 'مهلت پاسخ',
            'LettersResponseID' => 'Letters Response ID',
            'LettersAttachmentType' => 'Letters Attachment Type',
            'LettersAttachmentUrl' => 'Letters Attachment Url',
            'LettersAttachmentFileName' => 'نام فایل',
            'LettersArchiveType' => 'Letters Archive Type',
            'UsersID_FK' => 'Users Id  Fk',
            'FullNameSender' => 'ارجاع دهنده',
            'FullNameReceiver' => 'گیرنده',
            'FullCreator' => 'ایجاد کننده',
            'PersianLettersDraftType' => 'نوع',
            'PersianLettersType' => 'نوع نامه',
            'PersianLettersTypeOfAction' => 'نوع اقدام',
            'PersianLettersSecurity' => 'محرمانگی',
            'PersianLettersFollowType' => 'پیگیری',
            'PersianLettersResponseType' => 'مهلت پاسخ',
            'PersianLettersAttachmentType' => 'پیوست',
            'PersianLettersArchiveType' => 'بایگانی',
            'PersianReferralLettersReadType' => 'وضعیت',
        ];
    }
}
