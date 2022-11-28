<?php

namespace app\modules\Codnitive\Core\models\System\Source;

class Status extends \app\modules\Codnitive\Core\models\System\Source\OptionsArray
{
    protected $_module = \app\modules\Codnitive\Core\Module::MODULE_ID;

    public function optionsArray(): array
    {
        return [
            0 => __($this->getModule(), 'Not Registered'), 
            1 => __($this->getModule(), 'Pending'), 
            2 => __($this->getModule(), 'Canceled'),
            3 => __($this->getModule(), 'Confirmed'),
            101 => __($this->getModule(), 'Refunded'),
        ];
    }
}
