<?php

namespace app\modules\Codnitive\Account\models;

use yii\helpers\ArrayHelper;
use app\modules\Codnitive\Core\helpers\Rules;
use dektrium\user\models\RegistrationForm as BaseRegistration;
use kartik\password\StrengthValidator;
// use app\modules\Codnitive\Account\models\User;

class RegistrationForm extends BaseRegistration
{
    public $reCaptcha;

    /** @inheritdoc */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $newLabels = [
            'username'      => __('template', 'Cellphone'),
        ];
        return ArrayHelper::merge($labels, $newLabels);
    }

    /** @inheritdoc */
    public function rules()
    {
        $rules = parent::rules();
        unset($rules['passwordLength'], $rules['emailRequired']);
        $rules['usernameUnique']['message'] = __('account', 'This cellphone has already been registered');
        $rules['passwordStrength'] = ['password', StrengthValidator::className(), 'preset'=>'normal', 'userAttribute'=>'username'];
        $rules['emailUnique']['skipOnEmpty'] = true;
        return $rules;

//        return ArrayHelper::merge($rules, [
//            Rules::phone('username'),
//
//            // @link https://github.com/himiklab/yii2-recaptcha-widget
//            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator3::className(),
//                'threshold' => 0.5,
//                'action' => 'registration',
//            ],
//        ]);
    }

    /**
     * Registers a new user account. If registration was successful it will set flash message.
     *
     * @return bool
     */
    public function register()
    {
        // if (!$this->validate()) {
        //     return false;
        // }

        // /** @var User $user */
        // $user = \Yii::createObject(User::className());
        // $user->setScenario('register');
        // $this->loadAttributes($user);

        if (!parent::register()) {
            return false;
        }
        
        \Yii::$app->session->setFlash(
            'info',
            \Yii::t(
                'user',
                'Your account has been created successfully.'
            )
        );

        return true;
    }
}
