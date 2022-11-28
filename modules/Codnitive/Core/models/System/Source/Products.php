<?php

namespace app\modules\Codnitive\Core\models\System\Source;

class Products extends OptionsArray
{
    protected $_module = \app\modules\Codnitive\Core\Module::MODULE_ID;
    protected $_translation = false;

    public function optionsArray(): array
    {
        return app()->params['modules']['products'];
    }
}
