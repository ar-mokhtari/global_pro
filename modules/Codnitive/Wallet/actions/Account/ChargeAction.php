<?php

namespace app\modules\Codnitive\Wallet\actions\Account;

use app\modules\Codnitive\Wallet\actions\MainAction;
use app\modules\Codnitive\Wallet\models\Transaction;

class ChargeAction extends MainAction
{
    private $_params;
    
    /**
     * Disbale CSRF validation for loading search form
     */
    public function init()
    {
        parent::init();
        app()->controller->enableCsrfValidation = false;    
    }

    public function run()
    {
        $paymentParams = app()->session->get('payment_params');
        if (empty($paymentParams)) {
            $this->setFlash('warning', __('template', 'Unfortunately your session has been expired, please start over.'));
            return $this->controller->redirect(tools()->getUrl('account/wallet'));
        }
        
        $this->_params = $this->_getRequest()->post();

        $gateway = $this->_processPayment();
        if (!$gateway) {
            return $this->controller->redirect(tools()->getUrl('account/wallet'));
        }
        $transaction = (new Transaction)->setUserId((int) app()->getUser()->id)
            ->loadPendingTransaction($this->_params['ResNum']);
        if (!$transaction->id) {
            $this->setFlash('warning', __('wallet', 'This credit charge used before!'));
            return $this->controller->redirect(tools()->getUrl('account/wallet'));
        }
        $transaction = $transaction->addCharge();

        $this->setFlash('success', __('wallet', 'Charge added to your wallet successfully.'));
        return $this->controller->redirect(tools()->getUrl('account/wallet'));
    }

    private function _processPayment()
    {
        $paymentMethod = app()->session->get('payment_params')['payment_method'];
        app()->getModule(strtolower($paymentMethod));
        $gateway = getObject("app\modules\Codnitive\\$paymentMethod\models\Gateway");
        $gateway->setUserId(tools()->getUser()->id);
        $this->_params['wlt_id'] = $this->_params['ResNum'];
        // unset($this->_params['ResNum']);
        $verificationResult = $gateway->finalizeTransaction($this->_params);

        if (!isset($verificationResult['status']) || !$verificationResult['status']) {
            $this->setFlash('warning', $verificationResult['message']);
            return false;
        }
        return $gateway;
    }
}
