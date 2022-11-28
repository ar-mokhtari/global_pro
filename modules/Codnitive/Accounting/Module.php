<?php

namespace app\modules\Codnitive\Accounting;

class Module extends \app\modules\Codnitive\Core\Module
{
    public const MODULE_NAME = 'Accounting';

    public const MODULE_ID   = 'accounting';

    /**
     * Module unique id
     */
    protected $_moduleId = self::MODULE_ID;

    /**
     * Module config file path
     */

    protected $_config = __DIR__ . '/etc/config.php';

    /** @var array An array of administrator's usernames. */
    public $superadmins = [];
    public $agents = [];

}
