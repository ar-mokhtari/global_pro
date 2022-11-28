<?php 

namespace app\modules\Codnitive\Checkout\models;

// use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Sales\models\Order\PaymentInfo;
use app\modules\Codnitive\Account\models\User;

abstract class GatewayAbstract
{
    protected $_userId;
    protected $user;

    public function setUserId(int $userId)
    {
        $this->_userId = $userId;
        return $this;
    }

    public function getUser(): User
    {
        if (!$this->user) {
            $this->user = (new User)->loadOne((int) $this->_userId);
        }
        return $this->user;
    }

    public function getPaymentInfo(array $params, array $cart = []): PaymentInfo
    {
        $paymentInfo = new PaymentInfo;
        $paymentInfo->transaction_number = $params['RefNum'];
        $paymentInfo->trace_number = $params['TRACENO'];
        $paymentInfo->coupon_code = $cart['coupon_discount']['coupon_code'] ?? null;
        $paymentInfo->discount_amount = $cart['coupon_discount']['amount'] ?? 0;
        return $paymentInfo;
    }
}
