<?php 

namespace app\modules\Codnitive\Checkout\models;

use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Sales\models\Order\PaymentInfo;

interface TransactionInterface
{
    // public function setOrderId(int $orderId);
    public function loadByOrderId(int $orderId);
    public function loadTransaction(string $transNum, int $orderId);
    public function getTransactionTemplate(): string;
}
