<?php

namespace app\modules\Codnitive\Core;

class Module extends \yii\base\Module
{
    public const MODULE_NAME = 'Core';

    public const MODULE_ID   = 'core';

    /**
     * Module unique id
     */
    protected $_moduleId = self::MODULE_ID;

    /**
     * Module config file path
     */
    protected $_config = /** @lang text */
        __DIR__ . '/etc/config.php';

    /**
     * Parent module if exists
     */
    protected $_parent = null;

    protected $_childrenModules = [];

    protected $_providerConfigs = [];

    /**
     * Register module id, parent and configurations
     */
    public function __construct()
    {
        parent::__construct($this->_moduleId, $this->_parent, require($this->_config));
    }

    /**
     * Initialize module and translations
     */
    public function init()
    {
        require_once 'App.php';
        require_once 'Tools.php';
        require_once 'Dump.php';
        require_once 'ObjectManager.php';
        // \Yii::$classMap['yii\helpers\Url'] = '@app/modules/Codnitive/Core/helpers/Url.php';
        app()->on('beforeAction', function ($event) {
            app()->homeUrl = tools()->getUrl();
        });
        parent::init();
        $this->registerTranslations();
        $this->loadChildrenModules();
        $this->getProviderConfigs();
    }

    public function getProviderConfigs(): array
    {
        foreach ($this->_childrenModules as $module) {
            foreach ($this->_providerConfigs as $namespace) {
                if ($this->moduleLoaded($module) && isset(app()->modules[$module]->params[$namespace])) {
                    foreach (app()->modules[$module]->params[$namespace] as $key => $config) {
                        app()->params[$namespace][$key] = $config;
                    }
                }
            }
        }
        return app()->params;
    }

    /**
     * Register module translations
     */
    public function registerTranslations()
    {
        if (isset($this->translations)) {
            app()->i18n->translations[$this->_moduleId] = $this->translations;
        }
    }

    public function setChildrenModules(): self
    {
        if (isset(app()->params['modules']['providers'][static::MODULE_ID])) {
            $this->_childrenModules = app()->params['modules']['providers'][static::MODULE_ID];
        }
        return $this;
    }

    public function loadChildrenModules(): self
    {
        self::setChildrenModules();
        self::loadModules($this->_childrenModules);
        return $this;
    }

    public static function loadModules(array $modulesList)
    {
        foreach ($modulesList as $module) {
            if (static::MODULE_ID !== $module && app()->hasModule($module) && !self::moduleLoaded($module)) {
                app()->getModule($module);
            }
        }
    }

    public static function moduleLoaded(string $moduleId): bool
    {
        return app()->modules[$moduleId] instanceof \yii\base\Module;
    }

    public function getModuleName(): string
    {
        return static::MODULE_NAME;
    }
}
