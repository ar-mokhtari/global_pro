<?php

namespace app\modules\Codnitive\Sales\models\System\Source;

use app\modules\Codnitive\Core\models\System\Source\OptionsArray;

class OrderStatus extends OptionsArray
{
    protected $_module = \app\modules\Codnitive\Sales\Module::MODULE_ID;

    const PENDING           = 'Pending';
    const PENDING_PAYMENT   = 'Pending Payment';
    const PROCESSING        = 'Processing';
    const COMPLETED         = 'Completed';
    const CANCELED          = 'Canceled';
    const ON_HOLD           = 'On Hold';
    const REFUNDED          = 'Refunded';
    const CANCELED_BY_USER  = 'Canceled by User';
    const CANCELED_PAYMENT  = 'Payment Error Cancelation';
    const CANCELED_GATEWAY  = 'Gateway Connection Cancelation';
    const ISSUING_TICKET    = 'Issuing Ticket';

    const PENDING_ID           = 1;
    const PENDING_PAYMENT_ID   = 2;
    const PROCESSING_ID        = 3;
    const COMPLETED_ID         = 4;
    const CANCELED_ID          = 5;
    const ON_HOLD_ID           = 6;
    const REFUNDED_ID          = 7;
    const CANCELED_BY_USER_ID  = 8;
    const CANCELED_PAYMENT_ID  = 9;
    const CANCELED_GATEWAY_ID  = 10;
    const ISSUING_TICKET_ID    = 11;

    public function optionsArray(): array
    {
        return [
            self::PENDING_ID            => __($this->getModule(), self::PENDING),
            self::PENDING_PAYMENT_ID    => __($this->getModule(), self::PENDING_PAYMENT),
            self::PROCESSING_ID         => __($this->getModule(), self::PROCESSING),
            self::COMPLETED_ID          => __($this->getModule(), self::COMPLETED),
            self::CANCELED_ID           => __($this->getModule(), self::CANCELED),
            self::ON_HOLD_ID            => __($this->getModule(), self::ON_HOLD),
            self::REFUNDED_ID           => __($this->getModule(), self::REFUNDED),
            self::CANCELED_BY_USER_ID   => __($this->getModule(), self::CANCELED_BY_USER),
            self::CANCELED_PAYMENT_ID   => __($this->getModule(), self::CANCELED_PAYMENT),
            self::CANCELED_GATEWAY_ID   => __($this->getModule(), self::CANCELED_GATEWAY),
            self::ISSUING_TICKET_ID     => __($this->getModule(), self::ISSUING_TICKET),
        ];
    }
}
