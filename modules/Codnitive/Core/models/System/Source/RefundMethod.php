<?php

namespace app\modules\Codnitive\Core\models\System\Source;

class RefundMethod extends OptionsArray
{
    public const OFFLINE_ID         = 0;
    public const ONLINE_ID          = 1;
    public const NON_REFUNDABLE_ID  = 2;

    public const OFFLINE         = 'Offline';
    public const ONLINE          = 'Online';
    public const NON_REFUNDABLE  = 'Non-Refundable';

    protected $_module = \app\modules\Codnitive\Core\Module::MODULE_ID;

    public function optionsArray(): array
    {
        return [
            self::OFFLINE_ID        => __($this->getModule(), self::OFFLINE),
            self::ONLINE_ID         => __($this->getModule(), self::ONLINE), 
            self::NON_REFUNDABLE_ID => __($this->getModule(), self::NON_REFUNDABLE),
        ];
    }
}
