<?php

namespace app\modules\Codnitive\Core\models\System\Source;

class YesNo extends OptionsArray
{
    protected $_module = \app\modules\Codnitive\Core\Module::MODULE_ID;

    public function optionsArray(): array
    {
        return [
            1 => __($this->getModule(), 'Yes'), 
            0 => __($this->getModule(), 'No')
        ];
    }
}
