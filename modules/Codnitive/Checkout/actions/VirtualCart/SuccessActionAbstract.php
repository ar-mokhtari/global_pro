<?php

namespace app\modules\Codnitive\Checkout\actions\VirtualCart;

use yii\helpers\ArrayHelper;
use app\modules\Codnitive\Sales\models\Order;

abstract class SuccessActionAbstract extends ActionAbstract
{
    // protected $_moduleId = '';
    protected $_resultPageTemplate = '';
    protected $_params;
    protected $_checkoutResultStep = '';
    protected $_checkoutPrevStep = '';
    protected $_cart;
    protected $_order;
    protected $_breadcrumbs = '';
    protected $_breadcrumbsStep = 'success';
    protected $_color = 'orange';
    protected $_loadingGif = 'ticket-envelop.gif';
    protected $_successPhrase = 'Issuing your ticket';
    protected $_transactionVerificationResult;
    
    /**
     * Disbale CSRF validation after return from payemnt gateway
     */
    public function init()
    {
        parent::init();
        app()->controller->enableCsrfValidation = false;    
    }

    public function run()
    {
        try {
            if (app()->session->has('success_checkout') && app()->session->get('success_checkout')) {
                $this->setFlash('warning', __('template', 'This order was finished successfully, please search again.'));
                return $this->controller->redirect(tools()->getUrl('', ['tab' => "box-{$this->_moduleId}"]));
            }
            if (true !== $this->isValidCartSession()) return $this->isValidCartSession();

            app()->getModule($this->_moduleId);
            $this->_params = $this->_getRequest()->isPost
                ? $this->_getRequest()->post()
                : $this->_getRequest()->get();
            $this->_cart = $this->getCart();
            $this->_order = (new Order)->loadOne($this->_params['ResNum']);

            $gateway = $this->_processPayment();
            if (!$gateway) {
                intval($this->_params['StateCode']) === -1 
                    ? $this->_order->setOrderCanceledByUser()->save()
                    : $this->_order->setOrderCanceledPayment()->save();
                $blankParams  = tools()->stripEscapeRequest(app()->getRequest())->get('blank', false) ? ['blank' => '1', 'back' => '1'] : [];
                return $this->controller->redirect(tools()->getUrl($this->_checkoutPrevStep, $blankParams));
            }
            $couponDiscount = [
                'coupon_discount' => app()->session->get('payment_params')['coupon_discount'] ?? []
            ];
            $this->_order   = $this->_order->setSuccessPayment(
                $gateway->getPaymentInfo($this->_params, ArrayHelper::merge($this->_cart, $couponDiscount))
            );
            $this->_order->setOrderIssuingTicket()->save();
            app()->session->set('gateway', $gateway);
            app()->session->set('success_params', $this->_params);
            $this->setFlash('success', __('template', 'Your order registered successfully.'));

            $this->controller->setBodyClass($this->_getBodyClasses());
            $this->controller->view->title = $this->_getPageTitle();
            $renderParams = $this->_getRenderParams();
        }
        catch (\yii\db\Exception $e) {
            $renderParams = $renderParams ?? [];
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'I-Ch_a_VC_SAA');
            $msg = "Internal error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
        }
        catch (\Exception $e) {
            $renderParams = $renderParams ?? [];
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'G-Ch_a_VC_SAA');
            $msg = "General error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
        }
        
        $renderParams['breadcrumbs'] = $this->controller->renderPartial(
            '@app/modules/Codnitive/Template/views/templates/steps/_breadcrumbs.phtml',
            ['breadcrumbs' => getObject($this->_breadcrumbs)->getBreadcrumbs($this->_breadcrumbsStep)]
        );
        return $this->controller->render($this->_resultPageTemplate, $renderParams);
    }

    protected function _processPayment()
    {
        $session = app()->session->get('payment_params');

        if (!isset($session['payment_method']) || empty($session['payment_method'])) {
            $this->setFlash('error', __('checkout', 'No payment method found'));
            return false;
        }

        $paymentMethod = $session['payment_method'];
        app()->getModule(strtolower($paymentMethod));
        $gateway = getObject("app\modules\Codnitive\\$paymentMethod\models\Gateway");
        $gateway->setUserId(tools()->getUser()->id);
        $this->_transactionVerificationResult = $gateway->finalizeTransaction($this->_params);
        
        if ('Wallet' !== $paymentMethod && (isset($session['wallet_payment']) && boolval($session['wallet_payment']))) {
            $walletGateway = getObject("app\modules\Codnitive\Wallet\models\Gateway");
            $walletGateway->setUserId(tools()->getUser()->id);
            $this->_params['payment_method'] = $paymentMethod;
            $this->_params['payment_id'] = $this->_transactionVerificationResult['transaction']->id ?? 0;
            $finalizeResult = $walletGateway->finalizeTransaction($this->_params);
        }

        if (!isset($this->_transactionVerificationResult['status']) || !$this->_transactionVerificationResult['status']) {
            $this->setFlash('warning', $this->_transactionVerificationResult['message']);
            return false;
        }
        $this->setFlash('success', __('template', 'Your payment completed successfully.'));
        return $gateway;
    }

    protected function _getRenderParams(): array
    {
        // if (tools()->isJson($this->_order->payment_info)) {
        //     $this->_order->payment_info = Json::decode($this->_order->payment_info);
        // }
        // $paymentTraceNumber = $this->_order->payment_info->trace_number ?? $this->_order->payment_info['trace_number'];
        return [
            'orderNumber' => $this->_order->getOrderNumber(),
            'paymentTraceNumber' => $this->_order->payment_info->trace_number,
            'loadingGif' => $this->_loadingGif,
            'successPhrase' => __($this->_moduleId, $this->_successPhrase)
        ];
    }

    protected function _getBodyClasses(): string
    {
        return "success checkout {$this->_moduleId} {$this->_color}";
    }

    abstract protected function _getPageTitle(): string;
}
