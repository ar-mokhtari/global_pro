<?php 
namespace app\modules\Codnitive\Account\models;

class SendSms extends \app\modules\Codnitive\SmsIr\models\SendSmsAbstract
{
    public const MODULE_ID = 'account';
    public const SMS_TEMPLATE_ID = 19373;
    protected const SMS_TEMPLATE = 'PASSWORD_RECOVERY_SMS_TEMPLATE';

    protected $smsParams;

    public function __construct(
        \app\modules\Codnitive\SmsIr\models\SmsParams $smsParams
    )
    {
        $this->smsParams = $smsParams;
    }

    public function sendRecoveryPassword(\app\modules\Codnitive\Account\models\User $user)
    {
        $this->smsParams->cellphone  = $user->cellphone;
        $this->smsParams->params = [
            [
                'Parameter'      => 'new_pass',
                'ParameterValue' => $user->password
            ]
        ];
        $this->smsParams->templateId = self::SMS_TEMPLATE_ID;
        $this->smsParams->messages   = $this::getMessage($this->smsParams->params);
        return $this->send($this->smsParams)["IsSuccessful"];
    }
}
