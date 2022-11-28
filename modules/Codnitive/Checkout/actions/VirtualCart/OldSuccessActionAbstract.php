<?php

namespace app\modules\Codnitive\Checkout\actions\VirtualCart;

use yii\helpers\ArrayHelper;
use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\SmsIr\models\SmsParams;

abstract class OldSuccessActionAbstract extends ActionAbstract
{
    // protected $_moduleId = '';
    protected $_resultPageTemplate = '';
    protected $_params;
    protected $_checkoutResultStep = '';
    protected $_checkoutPrevStep = '';
    protected $_cart;
    protected $_repositoryModelClassName = '';
    protected $_repository;
    protected $_order;
    protected $_bookingStatus;
    protected $_ticketInfo;
    protected $_ticketPrintData;
    protected $_smsSender;
    protected $_breadcrumbs = '';
    protected $_breadcrumbsStep = 'success';
    protected $_color = 'orange';
    protected $_transactionVerificationResult;
    protected $_googleTagManagerClass  = '';
    
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
            $this->_cart  = $this->getCart();
            $this->_order = (new Order)->loadOne($this->_params['ResNum']);

            $gateway = $this->_processPayment();
            if (!$gateway) {
                intval($this->_params['StateCode']) === -1 
                    ? $this->_order->setOrderCanceledByUser()->save()
                    : $this->_order->setOrderCanceledPayment()->save();
                $blankParams = tools()->stripEscapeRequest(app()->getRequest())->get('blank', false) ? ['blank' => '1', 'back' => '1'] : [];
                return $this->controller->redirect(tools()->getUrl($this->_checkoutPrevStep, $blankParams));
            }
            $couponDiscount = [
                'coupon_discount' => app()->session->get('payment_params')['coupon_discount'] ?? []
            ];
            $this->_order   = $this->_order->setSuccessPayment(
                $gateway->getPaymentInfo($this->_params, ArrayHelper::merge($this->_cart, $couponDiscount))
            );
            $this->_order->setOrderIssuingTicket()->save();

            $this->_bookingStatus = $this->_processBooking();
            if ($this->_bookingStatus['ticket_number'] === false && 'revert' == $this->_bookingStatus['action']) {
                return $this->_revertAction($gateway, $this->_bookingStatus['message']);
            }
            else if ($this->_bookingStatus['ticket_number'] !== false && 'success' == $this->_bookingStatus['action']) {
                $this->_successAction();
            }
            else if ('continue' == $this->_bookingStatus['action'] && isset($this->_bookingStatus['message'])) {
                $this->setFlash('warning', $this->_bookingStatus['message']);
            }

            $this->removeCart();
            app()->session->remove('payment_params');
            app()->session->set('success_checkout', true);

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

        if (!empty($this->_googleTagManagerClass)) {
            $renderParams['dataLayer'] = $this->controller->renderPartial(
                '@app/modules/Codnitive/Checkout/views/templates/process/success/google_tag_manager_data_layer.js.phtml',
                ['block' => \Yii::createObject($this->_googleTagManagerClass, [
                    $this->_order,
                    $renderParams
                ])]
            );
        }
        return $this->controller->render($this->_resultPageTemplate, $renderParams);
    }

    protected function _processPayment()
    {
        $session = app()->session->get('payment_params');
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
        return $gateway;
    }

    protected function _processBooking(): array
    {
        $provider          = $this->_cart['reservation']['provider'];
        $this->_repository = getObject($this->_repositoryModelClassName, [$provider]);
        $bookingResult = $this->_repository->bookTicket($this->_cart, $this->_order);
        $this->_order->setAttribute('booking_result', $bookingResult);
        $this->_order->save();
        return $bookingResult;
    }

    protected function _revertAction($gateway, string $error)
    {
        $revertTransaction = $gateway->revertTransaction($this->_params['RefNum'], $this->_order->id);
        $this->setFlash('success', $revertTransaction['message']);
        $this->_cancelCheckoutAction($error);
    }

    protected function _cancelCheckoutAction(string $error)
    {
        $this->setFlash('danger', $error);
        app()->session->remove('payment_params');
        $this->_unsetCartData();
        $__virtual_cart = [
            $this->_moduleId => $this->_cart
        ];
        $this->setCart($__virtual_cart);
        $this->_order->setOrderCanceled()->save();
        return $this->controller->redirect(tools()->getUrl('', ['tab' => "box-{$this->_moduleId}"]));
    }

    protected function _unsetCartData()
    {
        unset(
            $this->_cart['data_source'], 
            $this->_cart['reservation']
        );
        return $this;
    }

    protected function _successAction()
    {
        $this->_ticketInfo = $this->_getTicketInfo();
        $this->_ticketInfo['ticket_id'] = $this->_bookingStatus['ticket_number'];
        
        $updateOrderStatus = $this->_order->saveTicketItemsData($this->_getOrderItemData());
        $this->_order->setOrderCompleted()->save();
        // $this->_order = (new Order)->loadOne($this->_order->id);
        $this->_ticketPrintData = $this->_repository->getTicketPrintData($this->_ticketInfo, $this->_order);
        
        $this->sendSms();

        !$updateOrderStatus 
            ? $this->setFlash('warning', __('template', 'We couldn\'t issue ticket, please save or print this information.'))
            : $this->setFlash('success', $this->_bookingStatus['message']);
        
        return $this;
    }

    protected function sendSms(): void
    {
        $params = $this->_getSmsParams();
        $smsData = new SmsParams;
        $smsData->cellphone  = $params['cellphone'];
        unset($params['cellphone']);
        $smsData->params = $params;
        $smsData->templateId = $this->_smsSender::SMS_TEMPLATE_ID;
        $smsData->messages   = $this->_smsSender::getMessage($smsData->params);
        app()->trigger($this->_smsSender::SUCCESS_CHECKOUT_AFTER_TICKET_ISSUE_SEND_SMS, $smsData);
    }

    protected function _getRenderParams(): array
    {
        return [
            'ticket' => $this->_ticketPrintData ?? []
        ];
    }

    protected function _getBodyClasses(): string
    {
        return "success checkout {$this->_moduleId} {$this->_color}";
    }

    abstract protected function _getOrderItemData(): array;
    abstract protected function _getTicketInfo(): array;
    abstract protected function _getPageTitle(): string;
    abstract protected function _getSmsParams(): array;
}
