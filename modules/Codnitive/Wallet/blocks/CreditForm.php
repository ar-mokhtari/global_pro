<?php 

namespace app\modules\Codnitive\Wallet\blocks;

use app\modules\Codnitive\Core\blocks\Template;
use app\modules\Codnitive\Checkout\blocks\Payment;

class CreditForm extends Template
{
    public function getGrandTotal()
    {
        return (new Payment)->getPayableGrandTotal(true);
        // $grandTotal = isset(app()->session->get('payment_params')['grand_total'])
        //     ? floatval(app()->session->get('payment_params')['grand_total'])
        //     : 0;

        // $discountAmount = isset(app()->session->get('payment_params')['coupon_discount']['amount']) 
        //     ? floatval(app()->session->get('payment_params')['coupon_discount']['amount'])
        //     : 0;
        // return $grandTotal - $discountAmount;
    }

    public function getAutoFillCreditFieldValue()
    {
        $userCredit = app()->getUser()->identity->credit_amount;
        return (int) min((float) $this->getGrandTotal(), (float) $userCredit);
    }
}
