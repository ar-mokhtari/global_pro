<?php

namespace app\modules\Codnitive\Core\models\System\Source;

use app\modules\Codnitive\Core\models\System\Source\OptionsArray;

class PopularCities extends OptionsArray
{
    protected $_module = \app\modules\Codnitive\Language\Module::MODULE_ID;

    public function optionsArray(): array
    {
        return [
            __($this->getModule(), 'Tehran'),
            __($this->getModule(), 'Mashhad'),
            __($this->getModule(), 'Esfahan'),
            __($this->getModule(), 'Tabriz'),
            __($this->getModule(), 'Shiraz'),
            __($this->getModule(), 'Ahvaz'),
            __($this->getModule(), 'Yazd'),
            __($this->getModule(), 'Rasht'),
            __($this->getModule(), 'Arak'),
            __($this->getModule(), 'Oromie'),
            __($this->getModule(), 'Ardebil'),
            __($this->getModule(), 'Kermanshah'),
            __($this->getModule(), 'Gorgan'),
            // __($this->getModule(), 'Sari'),

            // international cities
            __($this->getModule(), 'Paris'),
            __($this->getModule(), 'Frankfurt'),
            __($this->getModule(), 'London'),
            __($this->getModule(), 'New York'),
        ];
    }
}
