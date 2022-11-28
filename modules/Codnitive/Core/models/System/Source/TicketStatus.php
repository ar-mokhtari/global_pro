<?php

namespace app\modules\Codnitive\Core\models\System\Source;

class TicketStatus extends OptionsArray
{
    public const NOT_REGISTERED_ID  = 0;
    public const PENDINT_ID         = 1;
    public const CANCELED_ID        = 2;
    public const CONFIRMED_ID       = 3;
    public const ISSUED_ID          = 100;
    public const REFUNDED_ID        = 101;

    public const NOT_REGISTERED  = 'Not Registered';
    public const PENDINT         = 'Pending';
    public const CANCELED        = 'Canceled';
    public const CONFIRMED       = 'Confirmed';
    public const ISSUED          = 'Issued';
    public const REFUNDED        = 'Refunded';

    protected $_module = \app\modules\Codnitive\Core\Module::MODULE_ID;

    public function optionsArray(): array
    {
        return [
            self::NOT_REGISTERED_ID => __($this->getModule(), self::NOT_REGISTERED),
            self::PENDINT_ID        => __($this->getModule(), self::PENDINT), 
            self::CANCELED_ID       => __($this->getModule(), self::CANCELED),
            self::CONFIRMED_ID      => __($this->getModule(), self::CONFIRMED),
            self::ISSUED_ID         => __($this->getModule(), self::ISSUED),
            self::REFUNDED_ID       => __($this->getModule(), self::REFUNDED),
        ];
    }
}
