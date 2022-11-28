<?php

namespace app\modules\Codnitive\CentralOffice\models;

/**
 * This is the model class for table "users".
 *
 * @property int $UserID
 * @property string $UserName
 * @property string $UserFamily
 * @property string $UserUserName
 * @property string $UserPassword
 * @property int $UserGender
 * @property int $UserActivity
 * @property string $UserEmail
 * @property string $UserPhone
 * @property string $UserMobile
 * @property string $UserPicture
 * @property string $UserSign
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $confirmPass;

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
            [['UserName', 'UserFamily', 'UserUserName', 'UserPassword', 'UserGender', 'UserActivity'], 'required'],
            [['UserGender', 'UserActivity', 'UserID'], 'integer'],
            [['UserName', 'UserUserName'], 'string', 'max' => 100],
            ['UserUserName', 'unique'],
            ['UserUserName', 'trim'],
            [['UserFamily'], 'string', 'max' => 150],
            [['UserPassword'], 'string', 'max' => 50],
            ['confirmPass', 'compare', 'compareAttribute' => 'UserPassword', 'message' => 'کلمه عبور باید با "تکرار آن" برابر باشد'],
            [['UserEmail'], 'string', 'max' => 40],
            [['UserPhone', 'UserMobile'], 'string', 'max' => 30],
            [['UserPicture'], 'string', 'max' => 255],
            [['UserSign'], 'string', 'max' => 255],
            ['UserEmail', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'UserID' => 'کد کاربری',
            'UserName' => 'نام',
            'UserFamily' => 'نام خانوادگی',
            'UserUserName' => 'نام کاربری',
            'UserPassword' => 'کلمه عبور',
            'UserGender' => 'جنسیت',
            'UserActivity' => 'وضعیت',
            'UserEmail' => 'پست الکترونیکی(ایمیل)‏',
            'UserPhone' => 'تلفن',
            'UserMobile' => 'همراه',
            'UserPicture' => 'عکس',
            'UserSign' => 'امضاء',
            'confirmPass' => 'تکرار کلمه عبور'
        ];
    }
}
