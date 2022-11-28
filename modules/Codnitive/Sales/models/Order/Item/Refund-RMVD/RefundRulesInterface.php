<?php 

namespace app\modules\Codnitive\Sales\models\Order\Item\Refund;

interface RefundRulesInterface
{
    public function canRefund(\app\modules\Codnitive\Sales\models\Order\Item $item): bool;
}
