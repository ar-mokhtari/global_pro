<?php 

namespace app\modules\Codnitive\Checkout\models;

use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Account\models\User;

interface GatewayInterface
{
    public function setUserId(int $userId);
    public function getUser(): User;
    public function setupPayment(Order $order, array $params = [], string $callBackRoute = '', float $payableAmount = 0.0): array;
    public function finalizeTransaction(array $params): array;
    public function getTitle(): string;
    public function revertTransaction(string $refNumb, int $orderId, string $orderNumber = ''): array;
    public function refundAmount(float $refundAmount, string $orderNumber, string $ticketId, int $userId): bool;
}
