<?php

namespace app\modules\Codnitive\Calendar;

/**
 * Seiro Safar Nira API Module
 */
class Module extends \app\modules\Codnitive\Core\Module
{
    public const MODULE_NAME = 'Calendar';

    public const MODULE_ID   = 'calendar';

    /**
     * Module unique id
     */
    protected $_moduleId = self::MODULE_ID;

    /**
     * Module config file path
     */
    protected $_config = __DIR__ . '/etc/config.php';

}
