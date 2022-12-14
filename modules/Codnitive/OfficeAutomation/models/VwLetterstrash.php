<?php

namespace app\modules\Codnitive\OfficeAutomation\models;

/**
 * This is the model class for table "vw_letterstrash".
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
 * @property string $LettersAttachFileExtention
 * @property int $LettersArchiveType
 * @property int $UsersID_FK
 * @property int $LettersTrashID
 * @property int $LettersID_FK
 * @property int $UsersIDDeletor
 * @property string $LettersTrashDate
 * @property string $FullNameSender
 * @property string $FullNameDeletor
 * @property string $PersianLettersTypeOfAction
 * @property string $PersianLettersSecurity
 * @property string $PersianLettersArchiveType
 * @property string $PersianLettersFollowType
 * @property string $PersianLettersAttachmentType
 * @property string $PersianLettersType
 * @property string $PersianLettersResponseType
 * @property string $PersianLettersDraftType
 */
class VwLetterstrash extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function primaryKey()
    {
        return ['LettersTrashID'];
    }

    public static function tableName()
    {
        return 'oas_vw_letterstrash';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['LettersID', 'LettersDraftType', 'LettersType', 'LettersTypeOfAction', 'LettersSecurity', 'LettersFollowType', 'LettersResponseType', 'LettersResponseID', 'LettersAttachmentType', 'LettersArchiveType', 'UsersID_FK', 'LettersTrashID', 'LettersID_FK', 'UsersIDDeletor'], 'integer'],
            [['LettersText'], 'string'],
            [['LettersNumber', 'LettersDraftType', 'LettersType', 'UsersID_FK'], 'required'],
            [['LettersSubject'], 'string', 'max' => 400],
            [['LettersAbstract'], 'string', 'max' => 500],
            [['LettersCreateDate', 'LettersResponseDate', 'LettersTrashDate'], 'integer'],
            [['LettersNumber'], 'string', 'max' => 40],
            [['LettersAttachmentUrl', 'LettersAttachmentFileName'], 'string', 'max' => 200],
            [['LettersAttachFileExtention'], 'string', 'max' => 10],
            [['FullNameSender', 'FullNameDeletor'], 'string', 'max' => 251],
            [['PersianLettersTypeOfAction', 'PersianLettersAttachmentType'], 'string', 'max' => 11],
            [['PersianLettersSecurity', 'PersianLettersDraftType'], 'string', 'max' => 7],
            [['PersianLettersArchiveType', 'PersianLettersFollowType', 'PersianLettersType'], 'string', 'max' => 12],
            [['PersianLettersResponseType'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'LettersID' => 'Letters ID',
            'LettersSubject' => '?????????? ????????',
            'LettersText' => '?????? ????????',
            'LettersAbstract' => '??????????',
            'LettersCreateDate' => '?????????? ??????',
            'LettersNumber' => '?????????? ????????',
            'LettersDraftType' => '?????? ????????',
            'LettersType' => '?????????? ????????',
            'LettersTypeOfAction' => '?????? ??????????',
            'LettersSecurity' => '????????????????',
            'LettersFollowType' => '????????????',
            'LettersResponseType' => '???????? ????????',
            'LettersResponseDate' => '?????????? ???????? ????????',
            'LettersResponseID' => 'Letters Response ID',
            'LettersAttachmentType' => '??????????',
            'LettersAttachmentUrl' => '???????? ??????????',
            'LettersAttachmentFileName' => '?????? ???????? ??????????',
            'LettersArchiveType' => '??????????????',
            'UsersID_FK' => 'Users Id  Fk',
            'LettersTrashID' => '???? ??????',
            'LettersID_FK' => 'Letters Id  Fk',
            'UsersIDDeletor' => '???? ?????????? ?????? ??????????',
            'LettersTrashDate' => '?????????? ??????',
            'FullNameSender' => '??????????????',
            'FullNameDeletor' => '?????????? ?????? ??????????',
            'PersianLettersDraftType' => '?????????????????/????????',
            'PersianLettersType' => '????????/????????',
            'PersianLettersTypeOfAction' => '?????? ??????????',
            'PersianLettersSecurity' => '????????????????',
            'PersianLettersFollowType' => '????????????',
            'PersianLettersResponseType' => '???????? ????????',
            'PersianLettersAttachmentType' => '??????????',
            'PersianLettersArchiveType' => '??????????????',
        ];
    }
}
