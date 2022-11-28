<?php

namespace app\modules\Codnitive\Checkout\actions\VirtualCart;

// use app\modules\Codnitive\Core\actions\Action;

abstract class SearchActionAbstract extends ActionAbstract
{
    protected $_isSearch = true;
    protected $_searchParams = [];
    // protected $_moduleId = '';
    protected $_searchFormClassName = '';
    protected $_resultPageRoute = '';

    public function init()
    {
        // $this->_searchParams = tools()->stripOutInvisibles($this->_getRequest()->get($this->_moduleId));
        $this->_searchParams = $this->_getSearchParams();
        // $condition = !isset($this->_searchParams['trip']) || !isset($this->_searchParams['path']) 
        //     || (isset($this->_searchParams['trip']) && 1 == intval($this->_searchParams['trip']))
        //     || (isset($this->_searchParams['path']) && 1 == intval($this->_searchParams['path']));
        // if ($condition) {
            app()->session->remove('success_checkout');
        //     // app()->session->remove('__virtual_cart');
        //     // $this->removeCart();
        // }
    }

    public function run()
    {
        try {
            // $condition = isset($this->_searchParams['trip']) && isset($this->_searchParams['path']) 
            //     && 2 == intval($this->_searchParams['trip']) && 2 == intval($this->_searchParams['path']);
            if ($this->_isRoundTripStep()) {
                $this->_searchParams = $this->_getRoundTripSearchParams();
            }
            else if (isset($this->_searchParams['change_going_path_flight']) && intval($this->_searchParams['change_going_path_flight'])) {
                $this->_searchParams = $this->getCart()['going_path'];
            }

            if (!empty($this->_searchParams)) {
                $searchForm = getObject($this->_searchFormClassName);
                $searchForm->setAttributes($this->_searchParams);
                if (!$searchForm->validate()) {
                    $this->setFlash('danger', $searchForm->getErrorsFlash($searchForm->errors));
                    return $this->controller->redirect(tools()->getUrl('', ['tab' => "box-{$this->_moduleId}"]));
                }
                $this->setCart([$this->_moduleId => $this->_searchParams]);
            }
            return $this->controller->redirect(tools()->getUrl($this->_resultPageRoute, $this->_getRedirectParams()));
        }
        catch (\yii\db\Exception $e) {
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'I-Ch_a_VC_SAA');
            $msg = "Internal error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
            return $this->controller->redirect(tools()->getPreviousUrl());
        }
        catch (\Exception $e) {
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'G-Ch_a_VC_SAA');
            $msg = "General error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
            return $this->controller->redirect(tools()->getPreviousUrl());
        }
    }

    protected function _getRoundTripSearchParams(): array
    {
        $cart = $firstRoute = $this->getCart();
        unset($firstRoute['reservation']);
        $firstRoute['path'] = 1;
        $cart['going_path'] = $firstRoute;
        [$cart['origin_name'], $cart['destination_name']] = [$cart['destination_name'], $cart['origin_name']];
        [$cart['origin'], $cart['destination']] = [$cart['destination'], $cart['origin']];
        [$cart['departing'], $cart['round_departing']] = [$cart['round_departing'], $cart['departing']];
        [$cart['departing_persian'], $cart['round_departing_persian']] = [$cart['round_departing_persian'], $cart['departing_persian']];

        // $originName = $cart['destination_name'];
        // $origin = $cart['destination'];
        // $departion = $cart['round_departing'];
        // $departionPersian = $cart['round_departing_persian'];
        // $cart['destination_name'] = $cart['origin_name'];
        // $cart['destination'] = $cart['origin'];
        // $cart['round_departing'] = '';
        // $cart['round_departing_persian'] = '';

        return $cart;
    }

    protected function _getSearchParams(): array
    {
        return $this->_getRequest()->get($this->_moduleId);
    }

    abstract protected function _getRedirectParams(): array;
}
