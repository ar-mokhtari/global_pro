<?php 

namespace app\modules\Codnitive\Checkout\blocks;

use app\modules\Codnitive\Core\blocks\Template;

class Payment extends Template
{
    public const SESSION_PAYMENT_PARAMS_KEY = 'payment_params';

    protected $_paymentParams = [];
    
    public function __construct()
    {
        $this->_paymentParams = app()->session->get(self::SESSION_PAYMENT_PARAMS_KEY);
    }

    public function getGrandTotal(bool $number = false)
    {
        $grandTotal = $this->_paymentParams['grand_total'];
        return $number ? $grandTotal : tools()->formatRial($grandTotal);
    }

    public function getPayableGrandTotal(bool $number = false)
    {
        $grandTotal = floatval($this->getGrandTotal(true));
        if ($discountAmount = $this->getCouponDiscountAmount()) {
            $grandTotal -= $discountAmount;
        }
        if ($grandTotal < 0) {
            $grandTotal = 0;
        }
        return $number ? $grandTotal : tools()->formatRial($grandTotal);
    }

    public function getCouponDiscountAmount(bool $number = true)
    {
        // $grandTotal = floatval($this->getGrandTotal(true));
        $discountAmount = isset($this->_paymentParams['coupon_discount']['amount']) 
            ? floatval($this->_paymentParams['coupon_discount']['amount'])
            : 0;
        // if ($discountAmount > $grandTotal) {
        //     $discountAmount = $grandTotal;
        // }
        return $number ? $discountAmount : tools()->formatRial(-$discountAmount);
    }

    public function getAction(): string
    {
        return $this->_paymentParams['action'];
    }

    public function getButtonClass(): string
    {
        return $this->_paymentParams['checkout_button_class'];
    }
}
