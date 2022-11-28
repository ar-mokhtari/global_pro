<?php

namespace app\modules\Codnitive\Account\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\modules\Codnitive\Core\helpers\Rules;
use app\modules\Codnitive\Account\blocks\Settings;
use dektrium\user\models\SettingsForm as BaseSettings;
// use dektrium\user\Module;
use app\modules\Codnitive\Account\Module;
use dektrium\user\Mailer;
use kartik\password\StrengthValidator;

class SettingsForm extends BaseSettings
{
    public $fullname;
    public $cellphone;
    public $dob;
    public $gender;
    // public $location;
    // public $address;

    /** @inheritdoc */
    public function __construct(Mailer $mailer, $config = [])
    {
        parent::__construct($mailer, $config);
        $this->setAttributes([
            'username' => $this->user->username,
            'email'    => $this->user->unconfirmed_email ?: $this->user->email,

            'fullname'  => $this->user->fullname,
            'cellphone' => $this->user->cellphone,
            // 'cellphone' => $this->user->username,
            'dob'       => $this->user->dob,
            'gender'    => $this->user->gender,
            // 'location'  => $this->user->location,
            // 'address'   => $this->user->address,
        ], false);
    }

    // public function scenarios()
    // {
    //     exit('exit here');
    //     $scenarios = parent::scenarios();
    //     // add field to scenarios
    //     $scenarios['create'][]   = 'cellphone';
    //     $scenarios['update'][]   = 'cellphone';
    //     $scenarios['register'][] = 'cellphone';
    //     return $scenarios;
    // }

    /** @inheritdoc */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $newLabels = [
            'username'  => __('template', 'Cellphone'),
            'fullname'  => __('account', 'Full Name'),
            // 'cellphone' => __('user', 'Mobile'),
            'dob'       => __('template', 'Birthday'),
            'gender'    => __('template', 'Gender'),
            // 'location'  => __('user', 'Location'),
            // 'address'   => __('user', 'Address'),
        ];
        return ArrayHelper::merge($labels, $newLabels);
    }

    /** @inheritdoc */
    public function rules()
    {
        $rules = parent::rules();
        unset($rules['emailRequired']);
        $rules['emailUsernameUnique']['skipOnEmpty'] = true;
        $newRules = [
            [['fullname', 'cellphone', 'dob', 'gender', /*'location', 'address'*/
            ], 'safe'],
            [['fullname'], 'required'],
            Rules::phone('username'),
            Rules::trim(['fullname']),
            Rules::string('fullname', [3, 32]),
            Rules::phone('cellphone'),
            Rules::date('dob'),
            Rules::gender(),
            // Rules::string('location'),
            // Rules::address(),
        ];
        if ('change-password' == $this->getProfileAction()) {
            $newRules[] = [['new_password'], 'required'];
            $newRules['passwordStrength'] = ['new_password', StrengthValidator::className(), 'preset'=>'normal', 'userAttribute'=>'username'];
            unset($rules['newPasswordLength']);
        }
        return ArrayHelper::merge($rules, $newRules);

        // return ArrayHelper::merge($rules, [
        //     [['fullname'], 'required'],
        //     ['fullname', 'string', 'length' => [3, 32]],
        //     ['cellphone', 'match', 'pattern' => '/^(\+\d{1,3}[- ]?)?\d{8,11}$/'],
        //     ['dob', 'date', 'format' => 'yyyy-M-d'],
        //     ['gender', 'match', 'pattern' => '/^[0-1]$/'],
        //     ['country', 'string', 'length' => 2],
        //     ['division', 'string', 'length' => [2, 200]],
        //     ['city', 'string', 'length' => [2, 200]],
        //     ['address', 'string', 'length' => [5, 512]],
        // ]);
    }

    /**
     * Saves new account settings.
     *
     * @return bool
     */
    public function save()
    {
        if ($this->validate()) {
            $this->user->scenario = 'settings';
            $this->user->username = $this->username;
            $this->user->password = $this->new_password;

            $this->user->fullname   = $this->fullname;
            $this->user->cellphone  = $this->username;
            // $this->user->cellphone  = $this->cellphone;
            $this->user->dob        = $this->dob;
            $this->user->gender     = $this->gender;
            // $this->user->location   = $this->location;
            // $this->user->address    = $this->address;

            if ($this->email == $this->user->email && $this->user->unconfirmed_email != null) {
                $this->user->unconfirmed_email = null;
            } elseif ($this->email != $this->user->email) {
                switch ($this->module->emailChangeStrategy) {
                    case Module::STRATEGY_INSECURE:
                        $this->insecureEmailChange();
                        break;
                    case Module::STRATEGY_DEFAULT:
                        $this->defaultEmailChange();
                        break;
                    case Module::STRATEGY_SECURE:
                        $this->secureEmailChange();
                        break;
                    default:
                        throw new \OutOfBoundsException('Invalid email changing strategy');
                }
            }

            return $this->user->save();
        }

        return false;
    }

    public function getProfileAction()
    {
        return (new Settings)->getProfileAction();
    }
}
