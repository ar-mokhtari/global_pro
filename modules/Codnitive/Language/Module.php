<?php

namespace app\modules\Codnitive\Language;

class Module extends \app\modules\Codnitive\Core\Module
{
    public const MODULE_NAME = 'Language';

    public const MODULE_ID   = 'language';

    /**
     * Module unique id
     */
    protected $_moduleId = self::MODULE_ID;

    /**
     * Module config file path
     */
    protected $_config = __DIR__ . '/etc/config.php';

    /**
     * Initialize module and translations
     */
    public function init()
    {
        require_once 'Translator.php';
        app()->on('beforeAction', function ($event) {
            app()->language = tools()->getLanguage();
        });
        parent::init();
    }

}