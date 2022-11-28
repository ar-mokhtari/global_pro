<?php

namespace app\modules\Codnitive\Sales;

class Module extends \app\modules\Codnitive\Core\Module
{
    public const MODULE_NAME = 'Sales';

    public const MODULE_ID   = 'sales';

    /**
     * Module unique id
     */
    protected $_moduleId = self::MODULE_ID;

    /**
     * Module config file path
     */
    protected $_config = __DIR__ . '/etc/config.php';
}
