<?php 

namespace app\modules\Codnitive\Sales\models\Order\Item;

interface ProviderRefundInterface
{
    public function setOrderItem(\app\modules\Codnitive\Sales\models\Order\Item $item);
    public function canRefund(\app\modules\Codnitive\Sales\models\Order\Item $item): bool;
    /**
     * Codes:
     * 
     * -100.0 item refunded before
     * -10.0  item is not refundable
     * -20.0  refund request rejected
     * -1.0   unknown error occurred
     */
    public function refund();
    public function calcRefundAmount(): float;
    public function updateItem(int $itemId, $refundResult);
}
