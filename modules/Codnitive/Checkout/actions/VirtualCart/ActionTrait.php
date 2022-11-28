<?php

namespace app\modules\Codnitive\Checkout\actions\VirtualCart;

trait ActionTrait
{
    protected $_realModuleId = '';
    protected $_moduleId = '';

    /**
     * uesr id
     */
    private $_cacheUniqueId = 0;

    public function setCacheId($cacheUniqueId = 0): self
    {
        $this->_cacheUniqueId = $cacheUniqueId ?: (int) tools()->getUser()->id;
        return $this;
    }

    public function isValidCartSession()
    {
        if (null === $this->getCart()) {
            $this->setFlash('warning', __('template', 'Unfortunately your session has been expired, please search again.'));
            return $this->controller->redirect(tools()->getUrl('', ['tab' => "box-{$this->_moduleId}"]));
        }
        return true;
    }

    public function getVirtualCart()
    {
        return \app\modules\Codnitive\Checkout\helpers\Data::getVirtualCart();
    }

    public function getCart()
    {
        return \app\modules\Codnitive\Checkout\helpers\Data::getCart($this->_moduleId);
    }

    public function setCart(array $cart, $cartLabel = '__virtual_cart'): self
    {
        $cart['product'] = $this->_realModuleId ?: $this->_moduleId;
        if (!isset($cart['module'])) {
            $cart['module'] = $this->_realModuleId ?: $this->_moduleId;
        }

        if ($this->_cacheUniqueId) {
            $this->getStorage()->set(
                $this->getCacheCartKey($cartLabel), 
                $cart,
                app()->cache->defaultDuration * 2
            );
            return $this;
        }
        $this->getStorage()->set($cartLabel, $cart);
        return $this;
    }

    public function hasCart($cartLabel = '__virtual_cart'): bool
    {
        if ($this->_cacheUniqueId) {
            return $this->getStorage()->get($this->getCacheCartKey($cartLabel)) !== false;
        }
        return $this->getStorage()->has($cartLabel);
    }

    public function getStep()
    {
        return $this->getVirtualCart()['step'] ?? null;
    }

    public function removeCart($cartLabel = '__virtual_cart')
    {
        if ($this->_cacheUniqueId) {
            $this->getStorage()->delete($this->getCacheCartKey($cartLabel));
        }
        else {
            $this->getStorage()->remove($cartLabel);
        }
    }

    public function getStorage()
    {
        return $this->_cacheUniqueId ? app()->cache : app()->session;
    }

    public function getCacheCartKey($cartLabel = '__virtual_cart')
    {
        return "{$cartLabel}:{$this->_cacheUniqueId}";
    }

    protected function _isRoundTripStep()
    {
        return !(!isset($this->_searchParams['trip']) || !isset($this->_searchParams['path']) 
            || (isset($this->_searchParams['trip']) && 1 == intval($this->_searchParams['trip']))
            || (isset($this->_searchParams['path']) && 1 == intval($this->_searchParams['path'])));
    }
}
