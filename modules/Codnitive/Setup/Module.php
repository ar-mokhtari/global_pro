<?php

namespace app\modules\Codnitive\Setup;

class Module extends \yii\base\Module
{
    public const MODULE_NAME = 'Setup';

    public const MODULE_ID   = 'setup';

    /**
     * Module unique id
     */
    protected $_moduleId = self::MODULE_ID;

    public function init()
    {
        parent::init();
        \Yii::configure($this, require(__DIR__ . '/etc/config.php'));
    }
}
