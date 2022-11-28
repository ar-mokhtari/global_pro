<?php

namespace app\modules\Codnitive\Account\models;

use yii\helpers\ArrayHelper;
use app\modules\Codnitive\Core\helpers\Rules;
use dektrium\user\models\LoginForm as BaseLogin;

class LoginForm extends BaseLogin
{
    public $reCaptcha;

    /** @inheritdoc */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $newLabels = [
            'login'      => __('template', 'Cellphone'),
        ];
        return ArrayHelper::merge($labels, $newLabels);
    }

    /** @inheritdoc */
    public function rules()
    {
        $rules = parent::rules();
        return $rules;

//        return ArrayHelper::merge($rules, [
//            Rules::phone('login'),
//
//            // @link https://github.com/himiklab/yii2-recaptcha-widget
//            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator3::className(),
//                'threshold' => 0.5,
//                'action' => 'login',
//            ],
//        ]);
    }
}
