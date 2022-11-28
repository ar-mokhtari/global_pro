<?php

namespace app\modules\Codnitive\Template;

class Module extends \app\modules\Codnitive\Core\Module
{
    public const MODULE_NAME = 'Template';

    public const MODULE_ID   = 'template';

    /**
     * Module unique id
     */
    protected $_moduleId = self::MODULE_ID;

    /**
     * Module config file path
     */
    protected $_config = __DIR__ . '/etc/config.php';

    protected $_providerConfigs = ['products'];

}
