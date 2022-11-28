<?php

namespace app\modules\Codnitive\SmsIr;

/**
 * sms.ir api connector for sending sms
 */
class Module extends \app\modules\Codnitive\Core\Module
{
    public const MODULE_NAME = 'SmsIr';

    public const MODULE_ID = 'smsir';

    /**
     * Module unique id
     */
    protected $_moduleId = self::MODULE_ID;

    /**
     * Module config file path
     */
    protected $_config = __DIR__ . '/etc/config.php';

    public function init()
    {
        (new \app\modules\Codnitive\SmsIr\observers\SendSms)->runObservers();
    }

}
