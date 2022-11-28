<?php

namespace app\modules\Codnitive\Checkout\actions\VirtualCart;

abstract class ActionAbstract extends \app\modules\Codnitive\Core\actions\Action
{
    use ActionTrait;
    // protected $_realModuleId = '';
    // protected $_moduleId = '';
    
    public function __construnct()
    {
        app()->getModule('checkout');
        app()->getModule($this->_moduleId);
    }

    // public function isValidCartSession()
    // {
    //     if (null === $this->getCart()) {
    //         $this->setFlash('warning', __('template', 'Unfortunately your session has been expired, please search again.'));
    //         return $this->controller->redirect(tools()->getUrl('', ['tab' => "box-{$this->_moduleId}"]));
    //     }
    //     return true;
    // }

    // public function getVirtualCart()
    // {
    //     return \app\modules\Codnitive\Checkout\helpers\Data::getVirtualCart();
    // }

    // public function getCart()
    // {
    //     return \app\modules\Codnitive\Checkout\helpers\Data::getCart($this->_moduleId);
    // }

    // public function setCart(array $cart)
    // {
    //     $cart['product'] = $this->_realModuleId ?: $this->_moduleId;
    //     if (!isset($cart['module'])) {
    //         $cart['module'] = $this->_realModuleId ?: $this->_moduleId;
    //     }
    //     app()->session->set('__virtual_cart', $cart);
    //     return $this;
    // }

    // public function hasCart()
    // {
    //     return app()->session->has('__virtual_cart');
    // }

    // public function getStep()
    // {
    //     return $this->getVirtualCart()['step'] ?? null;
    // }

    // public function removeCart()
    // {
    //     app()->session->remove('__virtual_cart');
    // }

    // protected function _isRoundTripStep()
    // {
    //     return !(!isset($this->_searchParams['trip']) || !isset($this->_searchParams['path']) 
    //         || (isset($this->_searchParams['trip']) && 1 == intval($this->_searchParams['trip']))
    //         || (isset($this->_searchParams['path']) && 1 == intval($this->_searchParams['path'])));
    // }
}
