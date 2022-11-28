<?php

namespace app\modules\Codnitive\Wallet;

/**
 * Seiro Safar Nira API Module
 */
class Module extends \app\modules\Codnitive\Core\Module
{
    public const MODULE_NAME = 'Wallet';

    public const MODULE_ID   = 'wallet';
    
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
        $payments = $this->params['payments'];
        // app()->params['payments'][key($payments)] = reset($payments);
        foreach ($payments as $key => $payment) {
            app()->params['payments'][$key] = $payment;
        }
        parent::init();
    }

}
