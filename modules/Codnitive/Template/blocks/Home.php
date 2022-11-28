<?php 

namespace app\modules\Codnitive\Template\blocks;

// use app\modules\Codnitive\Core\Module as CoreModule;
use app\modules\Codnitive\Core\blocks\Template;

class Home extends Template
{
    public function getConfigs()
    {
        // CoreModule::loadModules(app()->params['modules']['products']);
        // CoreModule::loadModules(tools()->getOptionsArray('Core', 'Products'));
        $products = app()->params['products'];
        ksort($products);
        return $products;
    }
}
