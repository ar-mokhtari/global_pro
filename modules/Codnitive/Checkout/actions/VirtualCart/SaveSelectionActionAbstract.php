<?php

namespace app\modules\Codnitive\Checkout\actions\VirtualCart;

// use app\modules\Codnitive\Core\actions\Action;

abstract class SaveSelectionActionAbstract extends ActionAbstract
{
    protected $_selectionParams = [];
    // protected $_moduleId = '';
    protected $_checkoutStep = '';
    protected $_roundTripUrl = '';
    protected $_serviceField = 'services';
    protected $_serviceError = 'Please select some services.';

    public function run()
    {
        try {
            // if (null === $this->getCart()) {
            //     $this->setFlash('warning', __('template', 'Unfortunately your session has been expired, please search again.'));
            //     return $this->controller->redirect(tools()->getUrl('', ['tab' => "box-{$this->_moduleId}"]));
            // }
            if (true !== $this->isValidCartSession()) return $this->isValidCartSession();
            

            app()->getModule($this->_moduleId);
            $this->_selectionParams = $this->_getSelectionParams();
            if (empty($this->_selectionParams)) {
                return $this->controller->redirect(tools()->getPreviousUrl());
            }

            if (empty($this->_selectionParams) || empty($this->_selectionParams[$this->_serviceField])) {
                $this->setFlash('danger', __($this->_moduleId, $this->_serviceError));
                return $this->controller->redirect(tools()->getPreviousUrl());
            }

            $__virtual_cart = [
                'step' => $this->_checkoutStep,
                $this->_moduleId => $this->_updateCartData()
            ];
            $this->setCart($__virtual_cart);
        }
        catch (\yii\db\Exception $e) {
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'I-Ch_a_VC_SSAA');
            $msg = "Internal error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
        }
        catch (\Exception $e) {
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'G-Ch_a_VC_SSAA');
            $msg = "General error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
        }

        $params = tools()->stripEscapeRequest(app()->getRequest())
            ->get('blank', false) ? ['blank' => '1'] : [];
        $redirectUrl = $this->_getRedirectUrl($params);
        return $this->controller->redirect($redirectUrl);
    }

    protected function _getRedirectUrl(array $params): string
    {
        $data = $this->getCart();
        $url = tools()->getUrl($this->_checkoutStep, $params);
        $condition = (isset($data['trip']) && 2 == intval($data['trip'])) 
            && (isset($data['path']) && 2 == intval($data['path']))
            && (!isset($data['is_bundle']) || !$data['is_bundle']);
        if ($condition) {
            $params[$this->_moduleId]['trip'] = $data['trip'];
            $params[$this->_moduleId]['path'] = 2;
            $url = tools()->getUrl($this->_roundTripUrl, $params);
        }
        return $url;
    }

    protected function _updateCartData(): array
    {
        $data = $this->getCart();
        $fieldName = 'reservation';
        $condition = (isset($data['trip']) && 2 == intval($data['trip'])) 
            && (isset($data['path']) && 2 == intval($data['path']));
        if ($condition) {
            $fieldName = 'reservation_return';
            $data['path'] = 0;
        }
        $condition = (isset($data['trip']) && 2 == intval($data['trip'])) 
            && (isset($data['path']) && 1 == intval($data['path']))
            && (!isset($data['is_bundle']) || !$data['is_bundle']);
        if ($condition) {
            $data['path'] = 2;
        }
        $data[$fieldName] = $this->_selectionParams;
        return $data;
    }

    abstract protected function _getSelectionParams(): array;
}
