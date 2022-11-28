<?php

namespace app\modules\Codnitive\Account\models;

use yii\helpers\ArrayHelper;
use dektrium\user\models\RecoveryForm as BaseRecovery;
use app\modules\Codnitive\Account\helpers\Password;

class RecoveryForm extends BaseRecovery
{
    // public $reCaptcha;
    /**
     * @var string
     */
    public $cellphone;

    /**
     * @var Mailer
     */
    protected $smsSender;

    /**
     * @param Mailer $mailer
     * @param Finder $finder
     * @param array  $config
     */
    public function __construct(
        \app\modules\Codnitive\Account\models\SendSms $smsSender, 
        \dektrium\user\Mailer $mailer, 
        \dektrium\user\Finder $finder, 
        $config = []
    ) {
        $this->smsSender = $smsSender;
        parent::__construct($mailer, $finder, $config);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['cellphone'] = __('user', 'Cellphone');
        return  $labels;
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_REQUEST => ['cellphone'],
            self::SCENARIO_RESET => ['password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        return ArrayHelper::merge($rules, [
            // @reference https://github.com/himiklab/yii2-recaptcha-widget
            // [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator3::className(),
            //     'threshold' => 0.5,
            //     'action' => 'request',
            // ],
            'cellphoneTrim' => ['cellphone', 'trim'],
            'cellphoneRequired' => ['cellphone', 'required'],
            'cellphonePattern' => ['cellphone', 'match', 'pattern' => \app\modules\Codnitive\Core\helpers\Rules::CELLPHONE_PATTERN]
        ]);
    }

    /**
     * Sends recovery message.
     *
     * @return bool
     */
    public function sendRecoveryMessage()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = $this->finder->findUserByUsername($this->cellphone);

        if ($user instanceof User) {
            $user->password = Password::generate(6, 'numeric');
            if (!$user->save()) {
                return false;
            }

            if (!$this->smsSender->sendRecoveryPassword($user)) {
                return false;
            }
        }

        \Yii::$app->session->setFlash(
            'info',
            \Yii::t('user', 'A new password sent to your cellphone, please change it once you logged in.')
        );

        return true;
    }
}
