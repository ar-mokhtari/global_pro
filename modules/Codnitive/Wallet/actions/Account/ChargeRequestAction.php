<?php

namespace app\modules\Codnitive\Wallet\actions\Account;

use app\modules\Codnitive\Wallet\actions\MainAction;
use app\modules\Codnitive\Wallet\models\ChargeForm;
use app\modules\Codnitive\Wallet\models\Transaction;

class ChargeRequestAction extends MainAction
{
    public function run()
    {
        $chargeParams = tools()->stripEscapeRequest(app()->getRequest())->post('wallet_charge');
        $chargeForm = new ChargeForm;
        $chargeForm->setAttributes($chargeParams);
        if (!$chargeForm->validate()) {
            $this->setFlash('danger', $chargeForm->getErrorsFlash($chargeForm->errors));
            return $this->controller->redirect(tools()->getUrl('account/wallet'));
        }

        // @todo in future if we add more payment methods, we should get this 
        // parameter from request parameters to define payment method module and 
        // get gateway model
        $requestParams = [
            'payment_method' => 'SepMicro'
        ];
        $paymentMethod = $requestParams['payment_method'];
        $walletTransaction = (new Transaction)->setUserId(app()->getUser()->id)
            ->addChargeRequest((float) $chargeParams['charge_amount'], $paymentMethod);

        $gateway = getObject("app\modules\Codnitive\\$paymentMethod\models\Gateway");
        $gateway->setUserId(tools()->getUser()->id);
        $token   = $gateway->getToken($chargeParams['charge_amount'], $walletTransaction->id);
        $payment_params = [
            'payment_method' => $paymentMethod,
            'callback_address' => tools()->getUrl('account/wallet/charge', [], false, true),
            'token' => $token
        ];
        app()->session->set('payment_params', $payment_params);
        
        if ($walletTransaction->id && $token && strlen($token) > 3) {
            $walletTransaction->description = __('wallet', 'Charge request, redirect to {gateway} bank gateway.', ['gateway' => __('core', $gateway->getTitle())]);
            $walletTransaction->save();
            return $this->controller->redirect($gateway->getRedirectUrl());
        }

        $walletTransaction->description = __('wallet', 'Charge request added, we couldn\'t connect to gateway.');
        $walletTransaction->save();
        $this->setFlash('warning', __('template', 'We couldn\'t connect to gateway'));
        return $this->controller->redirect(tools()->getUrl('account/wallet'));
    }
}
