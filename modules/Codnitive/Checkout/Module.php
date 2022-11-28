<?php

namespace app\modules\Codnitive\Checkout;

/**
 * CMS pages module
 */
class Module extends \app\modules\Codnitive\Core\Module
{
    public const MODULE_NAME = 'Checkout';
    
    public const MODULE_ID   = 'checkout';
    /**
     * Module unique id
     */
    protected $_moduleId = self::MODULE_ID;

    /**
     * Module config file path
     */
    protected $_config = __DIR__ . '/etc/config.php';

}

