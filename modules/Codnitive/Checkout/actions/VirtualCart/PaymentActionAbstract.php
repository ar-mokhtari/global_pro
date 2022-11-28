<?php

namespace app\modules\Codnitive\Checkout\actions\VirtualCart;

use yii\helpers\ArrayHelper;
use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Checkout\exceptions\InvalidPaymentMethodException;

abstract class PaymentActionAbstract extends ActionAbstract
{
    use \app\modules\Codnitive\Checkout\actions\VirtualCart\OrderActionTrait;

    // protected $_moduleId = '';
    protected $_cart;
    protected $_requestParams;
    protected $_confirmRoute = '';
    protected $_callbackRoute = '';
    protected $_repositoryModelClassName = '';
    protected $_orderItemClass = '';
    protected $_formDataField = '';
    protected $_registrationUrl = '';
    protected $_checkoutStep = '';
    protected $_validToProcess = true;
    protected $_invalidProcessData = [];

    public function run()
    {
        try {
            // if (null === $this->getCart()) {
            //     $this->setFlash('warning', __('template', 'Unfortunately your session has been expired, please search again.'));
            //     return $this->controller->redirect(tools()->getUrl('', ['tab' => "box-{$this->_moduleId}"]));
            // }
            if (true !== $this->isValidCartSession()) return $this->isValidCartSession();
            if (tools()->isGuest()) {
                $this->setFlash('warning', __('template', 'Please login or create an account'));
                return $this->controller->redirect(tools()->getUrl($this->_registrationUrl));
            }
            app()->getModule('checkout');
            if (!$this->_validToProcess) {
                return $this->_handelInvalidProcess();
            }

            app()->getModule($this->_moduleId);
            $this->_requestParams = $this->_getRequestParams();
            if (!isset($this->_requestParams['payment_method']) || empty($this->_requestParams['payment_method'])) {
                $this->setFlash('danger', __('template', 'Please select a payment method.'));
                return $this->controller->redirect($this->_getRedirectUrl());
            }
            $paymentMethod = $this->_requestParams['payment_method'];
            if (!$this->_validatePeymentMethod($paymentMethod)) {
                throw new InvalidPaymentMethodException(__('checkout', 'Invalid payment method.'));
            }
            $this->_cart   = $this->getCart();

            $grandTotal    = (int) $this->_getGrandTotal();
            $billingData   = $this->_getBillingData();
            $items         = $this->_getOrderItems();
            $order         = (new Order)->saveOrder($grandTotal, $paymentMethod, $billingData, $items);
            $gateway       = getObject("app\modules\Codnitive\\$paymentMethod\models\Gateway");
            $gateway->setUserId(tools()->getUser()->id);
            $setupPayment  = $gateway->setupPayment(
                $order, 
                $this->_requestParams, 
                $this->_callbackRoute
            );

            if ($setupPayment['status'] && !empty($setupPayment['redirect'])) {
                if (app()->getModule('coupon')) {
                    (new \app\modules\Codnitive\Coupon\models\Code)->saveUsedCoupon(
                        $order, 
                        app()->session->get('payment_params')
                    );
                }
                return $this->controller->redirect($setupPayment['redirect']);
            }
            $order->setOrderCanceledGateway()->save();
            $this->setFlash('warning', __('template', $setupPayment['message']));
            return $this->controller->redirect($this->_getRedirectUrl());
        }
        catch (\yii\db\Exception $e) {
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'I-Ch_a_VC_PAA');
            $msg = "Internal error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
            return $this->controller->redirect(tools()->getPreviousUrl());
        }
        catch (\Exception $e) {
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'G-Ch_a_VC_CAA');
            $msg = "General error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
            return $this->controller->redirect(tools()->getPreviousUrl());
        }
    }

    protected function _handelInvalidProcess()
    {
        $this->controller->layout      = '@app/modules/Codnitive/Template/views/layouts/blank';
        $this->controller->view->title = __('checkout', 'Confirm process to payment');
        return $this->controller->render(
            '@app/modules/Codnitive/Checkout/views/templates/validate_modal.phtml', ArrayHelper::merge([
                'title' => $this->controller->view->title
            ], $this->_invalidProcessData));
    }

    protected function _getRequestParams()
    {
        return tools()->stripEscapeRequest(app()->getRequest())->post();
    }

    protected function _getRedirectUrl()
    {
        $params = tools()->stripEscapeRequest(app()->getRequest())->get('blank', false) ? ['blank' => '1'] : [];
        return tools()->getUrl($this->_confirmRoute, $params);
    }
}
