<?php 
namespace app\modules\Codnitive\Checkout\actions\VirtualCart;

use app\modules\Codnitive\Sales\models\Order\BillingData;

trait OrderActionTrait
{
    protected function _getGrandTotal(): float
    {
        $grandTotal = \getObject($this->_repositoryModelClassName, [$this->_cart['reservation']['provider']])
            ->getGrandTotal($this->_cart);
        $paymentParams = \app()->session->get('payment_params');
        if(isset($paymentParams['coupon_discount']['amount'])) {
            $grandTotal -= $paymentParams['coupon_discount']['amount'];
        }
        return $grandTotal > 0 ? $grandTotal : 0;
    }

    protected function _getOrderItems()
    {
        return getObject($this->_orderItemClass)->getOrderItems($this->_cart);
    }

    protected function _getBillingData(): BillingData
    {
        $billingData = new BillingData;
        $billingData->setAttributes($this->_cart[$this->_formDataField]);
        return $billingData;
    }

    protected function _validatePeymentMethod(string $paymentMethod): bool
    {
        $paymentTitles  = [];
        foreach (app()->params['modules']['payments'] as $payment) {
            $paymentTitles[] = app()->getModule($payment)->getModuleName();
        }
        return array_search($paymentMethod, $paymentTitles) !== false;
    }
}
