<?php

namespace app\modules\Codnitive\Core\models\System\Source;

class Gender extends OptionsArray
{
    protected $_module = \app\modules\Codnitive\Core\Module::MODULE_ID;

    public function optionsArray(): array
    {
        return [
            0 => __($this->getModule(), 'Female'),
            1 => __($this->getModule(), 'Male')
        ];
    }
}
