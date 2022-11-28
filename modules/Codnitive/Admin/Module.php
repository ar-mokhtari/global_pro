<?php

namespace app\modules\Codnitive\Admin;

/**
 * Ati Shahr Museum API Module
 */
class Module extends \app\modules\Codnitive\Core\Module
{
    public const MODULE_NAME = 'Admin';

    public const MODULE_ID = 'admin';
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
        parent::init();
        $this->initPanelChargeConfig();
    }

    public function initPanelChargeConfig(): self
    {
        $providers = [];
        foreach (app()->params['modules']['products'] as $product) {
            if (isset(app()->params['modules']['providers'][$product])) {
                $providers = \yii\helpers\ArrayHelper::merge($providers, app()->params['modules']['providers'][$product]);
            }
        }
        $providers = array_unique($providers);
        $this->loadModules($providers);
        foreach ($providers as $provider) {
            if ($this->moduleLoaded($provider) && isset(app()->modules[$provider]->params['api_connector'])) {
                app()->params['api_connector'][$provider] = app()->modules[$provider]->params['api_connector'];
            }
        }
        return $this;
    }
}
