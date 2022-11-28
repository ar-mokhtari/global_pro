<?php

namespace app\modules\Codnitive\Checkout\actions\VirtualCart;

// use yii\helpers\ArrayHelper;
// use app\modules\Codnitive\Core\actions\Action;
// use app\modules\Codnitive\Insurance\blocks\Breadcrumbs;
// use app\modules\Codnitive\Core\models\DynamicModel;
// use app\modules\Codnitive\Bus\blocks\Process\Confirm;

abstract class ConfirmActionAbstract extends ActionAbstract
{
    // protected $_moduleId = '';
    protected $_resultPageTemplate = '';
    protected $_checkoutStep = '';
    protected $_checkoutPrevStep = '';
    protected $_breadcrumbs = '';
    protected $_breadcrumbsStep = 'confirm';
    protected $_registrationFormModel = '';
    protected $_confirmBlock = '';
    protected $_formPostDataField = '';
    protected $_formDataField = '';
    protected $_color = 'orange';
    protected $_checkoutButtonClass = 'btn-full-color';
    protected $_passengerBookClass = '';

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
                return $this->controller->redirect(tools()->getUrl($this->_checkoutPrevStep));
            }

            app()->getModule($this->_moduleId);
            $formData = $this->_getRequest()->post($this->_formPostDataField);
            if (!empty($formData)) {
                $registrationModel = $this->_validateFormData($formData);
                if (!$registrationModel) {
                    return $this->controller->redirect(tools()->getUrl($this->_checkoutPrevStep));
                }
                $data = $this->getCart();
                $data[$this->_formDataField] = $this->_updateFormData($formData);
                if (!empty($this->_passengerBookClass)) {
                    getObject($this->_passengerBookClass)->savePassengers($data[$this->_formDataField]);
                }
                $__virtual_cart = [
                    'step' => $this->_checkoutStep,
                    $this->_moduleId => $data
                ];
                $this->setCart($__virtual_cart);
            }
            $this->_updatePaymentSession($this->getCart());
            
            $this->controller->setBodyClass($this->_getBodyClasses());
            $this->controller->view->title = $this->_getPageTitle();
            $renderParams = $this->_getRenderParams();
        }
        catch (\yii\db\Exception $e) {
            $renderParams = $renderParams ?? [];
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'I-Ch_a_VC_CAA');
            $msg = "Internal error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
        }
        catch (\Exception $e) {
            $renderParams = $renderParams ?? [];
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'G-Ch_a_VC_CAA');
            $msg = "General error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
        }
        
        $renderParams['breadcrumbs'] = $this->controller->renderPartial(
            '@app/modules/Codnitive/Template/views/templates/steps/_breadcrumbs.phtml',
            ['breadcrumbs' => getObject($this->_breadcrumbs)->getBreadcrumbs($this->_breadcrumbsStep)]
        );
        return $this->controller->render($this->_resultPageTemplate, $renderParams);
    }

    protected function _getRenderParams(): array
    {
        return [
            'data' => $this->getCart(),
            'block' => getObject($this->_confirmBlock, [$this->getCart()])
        ];
    }

    protected function _getBodyClasses(): string
    {
        return "confirm checkout {$this->_moduleId} {$this->_color}";
    }

    protected function _validateFormData(array $formData)
    {
        $registrationModel = getObject($this->_registrationFormModel);
        $registrationModel->setAttributes($formData);
        if (!$registrationModel->validate()) {
            $this->setFlash('danger', $registrationModel->getErrorsFlash($registrationModel->errors));
            return $this->controller->redirect(tools()->getUrl($this->_checkoutPrevStep));
        }
        return $registrationModel;
    }

    protected function _updateFormData(array $formData): array
    {
        return tools()->convertFormArrayToModelArray($formData);
    }

    protected function _updatePaymentSession(array $data): void
    {
        // $grandTotal = (new Confirm($data))->getGrandTotal(true);
        $block = getObject($this->_confirmBlock, [$data]);
        $grandTotal = $block->getGrandTotal(true);
        $payment_params = [
            'grand_total' => $grandTotal,
            'action' => $this->_getCheckoutAction(),
            'checkout_button_class' => $this->_checkoutButtonClass,
        ];

        app()->session->set('payment_params', $payment_params);
    }

    protected function _getCheckoutAction(): string
    {
        $module = $this->_realModuleId ?: $this->_moduleId;
        return tools()->getUrl($module . '/process/payment');
    }

    abstract protected function _getPageTitle(): string;
    // abstract protected function _getCheckoutAction($block): string;
    // abstract protected function _getCalculatedTotals($block): array;
}
