<?php

namespace app\modules\Codnitive\Checkout\actions;

use Yii;
// use yii\base\Action;
use app\modules\Codnitive\Core\actions\Action;
// use app\modules\Codnitive\Core\helpers\Tools;
// use app\modules\Codnitive\Event\models\Event;
// use app\modules\Codnitive\Checkout\models\CartItem;
// use app\modules\Codnitive\Adyen\models\Sdk as AdyenSdk;

class IndexAction extends Action
{
    public function run()
    {
        $virtualCart = \app\modules\Codnitive\Checkout\helpers\Data::getVirtualCart();
        if (isset($virtualCart['step'])) {
            return $this->controller->redirect(tools()->getUrl($virtualCart['step']));
        }
        return $this->controller->render('/cart/empty.phtml');


        // $this->controller->setBodyClass('my-check-out cart');
        // $cart = Yii::$app->cart;
        // $this->_prepareCartData();
        // $cart->checkItemsAvailability()
        //     ->checkItemsAvailabilityErrors();
        // // $this->_checkQtyErrors();
        // return $this->controller->render('/cart', [
        //     'cart' => $cart/*?: Yii::$app->cart*/,
        //     // 'adyenSession' => (new AdyenSdk)->getSession(),
        // ]);
    }

    // private function _checkQtyErrors()
    // {
    //     $session    = Yii::$app->session;
    //     $qtyErrors  = $session->get(CartItem::AVAILABLE_QTY_ERROR);
    //     if (empty($qtyErrors)) {
    //         return $this;
    //     }
    //     $session->remove(CartItem::AVAILABLE_QTY_ERROR);
    //     $message    = '';
    //     foreach ($qtyErrors as $errors) {
    //         $message .= implode("<br>\n", $errors) . "<br>\n";
    //     }
    //     $this->setFlash('danger', $message);
    //     return $this;
    // }

    // private function _prepareCartData()
    // {
    //     if (!empty(Yii::$app->cart->billingInfo)) {
    //         return $this;
    //     }

    //     $billingInfo = [
    //         'email'    => '',
    //         'fullname' => '',
    //         'address'  => '',
    //         'location' => '',
    //         'phone'    => '',
    //         'zipcode'  => ''
    //     ];

    //     $session = Yii::$app->session;
    //     if ($session->has('billing_data')) {
    //         $billingInfo = $session->get('billing_data');
    //         $session->remove('billing_data');
    //     }
    //     elseif (!Tools::isGuest()) {
    //         $userInfo = Tools::getUser()->identity->attributes;
    //         $billingInfo = [
    //             'email'    => $userInfo['email'],
    //             'fullname' => $userInfo['fullname'],
    //             'address'  => $userInfo['address'],
    //             'location' => $userInfo['location'],
    //             'phone'    => $userInfo['cellphone'],
    //             'zipcode'  => ''
    //         ];
    //     }
        
    //     Yii::$app->cart->billingInfo = $billingInfo;
    //     return $this;
    // }
}
