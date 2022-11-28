<?php 

namespace app\modules\Codnitive\Wallet\models;

use app\modules\Codnitive\Sales\models\Order;
// use app\modules\Codnitive\Sales\models\Order\PaymentInfo;

class Gateway extends \app\modules\Codnitive\Checkout\models\GatewayAbstract
    implements \app\modules\Codnitive\Checkout\models\GatewayInterface
{
    public const PAYMENT_METHOD = 'Wallet';

    private   $_defaultOnlineGateway = 'SepMicro';

    protected $_userCredit = 0.0;
    protected $_order;

    public function __construct()
    {
        app()->getModule(\app\modules\Codnitive\Wallet\Module::MODULE_ID);
    }

    public function setDefaultOnlineGateway(string $gatewayName): self
    {
        $this->_defaultOnlineGateway = $gatewayName;
        return $this;
    }

    public function getDefaultOnlineGateway(): string
    {
        return $this->_defaultOnlineGateway;
    }

    public function setupPayment(Order $order, array $params = [], string $callBackRoute = '', float $payableAmount = 0.0): array
    {
        if (tools()->isGuest()) {
            return [
                'status'   => false,
                'message'  => 'To use your wallet you must be logged in.',
                'redirect' => ''
            ];
        }
        $this->_order       = $order;
        // $grandTotal         = (float) $this->_order->grand_total;
        $grandTotal         = $payableAmount ?: (float) $this->_order->grand_total;
        $usingCredit        = isset($params['wallet_used_credit']) ? (float) $params['wallet_used_credit'] : 0.0;
        // $usingCredit        = $usingCredit > $grandTotal ? $grandTotal : $usingCredit;
        $usingCredit        = min($grandTotal, $usingCredit);
        $this->_userCredit  = (float) $this->getUser()->credit_amount;
        $checkCreditAmount  = $this->_checkRequestedCreditAmount($usingCredit, $grandTotal);
        $this->_updateSession($grandTotal, $usingCredit);

        if (!$checkCreditAmount['status']) {
            return [
                'status'   => $checkCreditAmount['status'],
                'message'  => $checkCreditAmount['message'],
                'redirect' => ''
            ];
        }

        $usedCreditObj = $usingCredit >= 0
            // ? (new Transaction)->useCredit($usingCredit, $this->_order->getOrderNumber())
            ? (new Transaction)->setUserId(app()->getUser()->id)->useCredit($usingCredit, $this->_order)
            : 0;

        $payableAmount = $grandTotal - abs((float) $usedCreditObj->change_amount);
        if ($payableAmount > 0) {
            $payOnlineResult = $this->_payOnline($callBackRoute, $payableAmount);
            return $payOnlineResult;
        }

        return [
            'status'   => true,
            'message'  => 'Payment with your credit was successful.',
            'redirect' => tools()->getUrl(
                $callBackRoute, 
                [
                    'ResNum' => $this->_order->id, 
                    'RefNum' => $usedCreditObj->id, 
                    'TRACENO' => $usedCreditObj->getTransactionNumber()], 
                false, 
                true
            )
        ];
    }

    protected function _payOnline(string $callBackRoute, float $payableAmount): array
    {
        $paymentMethod = $this->getDefaultOnlineGateway();
        $gateway       = getObject("app\modules\Codnitive\\$paymentMethod\models\Gateway");
        $gateway->setUserId(tools()->getUser()->id);
        $requestParams = ['payment_method' => implode(', ', [self::PAYMENT_METHOD, $paymentMethod])];
        return $gateway->setupPayment(
            $this->_order, 
            $requestParams, 
            // tools()->getUrl($callBackRoute, [], false, true),
            $callBackRoute,
            $payableAmount
        );
    }

    public function finalizeTransaction(array $params): array
    {
        if (isset($params['payment_method']) && isset($params['payment_id'])) {
            $transaction = (new Transaction)->loadByOrderId($params['ResNum']);
            $transaction->payment_method = $params['payment_method'];
            $transaction->payment_id = $params['payment_id'];
            $transaction->save();
        }

        return [
            'status'  => true,
            'message' => __('wallet', 'Payment from your wallet was successful.')
        ];
    }

    public function revertTransaction(string $refNumb, int $orderId, string $orderNumber = ''): array
    {
        $transaction = (new Transaction)->setUserId(tools()->getUser()->id)
            ->revertCredit(intval($refNumb), $orderNumber);
        return [
            'status' => true,
            'message' => __('wallet', 'Your credit refund to your wallet.')
        ];
    }

    public function refundAmount(float $refundAmount, string $orderNumber, string $ticketId, int $userId): bool
    {
        return (new Transaction)
            ->setUserId($userId)
            ->refundCredit($refundAmount, $orderNumber, $ticketId);
            // ->refundCredit($refundAmount, $orderNumber, $ticketId) instanceof Transaction ? true : false;
    }

    private function _updateSession(float $grandTotal, float $usingCredit): void
    {
        $payment_params = app()->session->get('payment_params');
        $payment_params = \yii\helpers\ArrayHelper::merge($payment_params, [
            'payment_method' => self::PAYMENT_METHOD,
            // 'grand_total' => $grandTotal,
            'wallet_payment' => true,
            'wallet_used_credit' => min($grandTotal, $usingCredit)
            // 'wallet_used_credit' => $usingCredit > $grandTotal ? $grandTotal : $usingCredit
        ]);
        app()->session->set('payment_params', $payment_params);
    }

    protected function _checkRequestedCreditAmount(float $usingCredit, $grandTotal = 0.0): array
    {
        $status         = true;
        $message        = '';
        $grandTotal     = $grandTotal ?: (float) $this->_order->grand_total;
        if ($usingCredit > $this->_userCredit) {
            $message    = 'You don\'t have enough credit in your wallet.';
            $status     = false;
        }
        elseif ($usingCredit > $grandTotal) {
            $message    = 'Requested credit to use is more than your cart grand total.';
            $status     = false;
        }
        return [
            'status'  => $status,
            'message' => $message
        ];
    }

    public function getTitle(): string
    {
        return __('wallet', 'Wallet Payment');
    }
}
