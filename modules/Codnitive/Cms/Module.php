<?php

namespace app\modules\Codnitive\Cms;

/**
 * CMS pages module
 */
class Module extends \app\modules\Codnitive\Core\Module
{
    public const MODULE_NAME = 'Cms';

    public const MODULE_ID = 'cms';
    /**
     * Module unique id
     */
    protected $_moduleId = self::MODULE_ID;

    /**
     * Module config file path
     */
    protected $_config = __DIR__ . '/etc/config.php';

}
