<?php

namespace app\modules\Codnitive\Core\models\System\Source;

class Sort extends OptionsArray
{
    protected $_module = \app\modules\Codnitive\Core\Module::MODULE_ID;

    public function optionsArray(): array
    {
        return [
            'inexpensive' => __($this->getModule(), 'Sort by Inexpensive'),
            'expensive'   => __($this->getModule(), 'Sort by Expensive'),
            'newest'      => __($this->getModule(), 'Sort by Newest'),
            'oldest'      => __($this->getModule(), 'Sort by Oldest'),
            'current'     => __($this->getModule(), 'Sort by Current'),
            'future'      => __($this->getModule(), 'Sort by Future'),
        ];
    }
}
