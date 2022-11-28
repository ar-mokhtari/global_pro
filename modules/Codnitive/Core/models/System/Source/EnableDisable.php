<?php

namespace app\modules\Codnitive\Core\models\System\Source;

class EnableDisable extends OptionsArray
{
    protected $_module = \app\modules\Codnitive\Core\Module::MODULE_ID;

    public function optionsArray(): array
    {
        return [
            1 => __($this->getModule(), 'Enable'), 
            0 => __($this->getModule(), 'Disable')
        ];
    }
}
