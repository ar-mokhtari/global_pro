<?php

namespace app\modules\Codnitive\Core\models\System\Source;

class PriceChangeType extends \app\modules\Codnitive\Core\models\System\Source\OptionsArray
{
    public const FIXED   = 1;
    public const PERCENT = 2;

    protected $_module = \app\modules\Codnitive\Core\Module::MODULE_ID;

    public function optionsArray(): array
    {
        return [
            self::FIXED   => __($this->getModule(), 'Fixed'),
            self::PERCENT => __($this->getModule(), 'Percent'),
        ];
    }
}
