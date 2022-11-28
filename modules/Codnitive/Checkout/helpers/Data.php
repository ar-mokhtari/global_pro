<?php

namespace app\modules\Codnitive\Checkout\helpers;

class Data
{
    public static function getVirtualCart($cartLabel = '__virtual_cart')
    {
        if ($sessionCart = app()->session->get($cartLabel)) {
            return $sessionCart;
        }
        if (($cacheCrat = app()->cache->get(self::getCacheCartKey($cartLabel))) !== false) {
            return $cacheCrat;
        }
        return null;
    }

    public static function getCart(string $moduleId, $cartLabel = '__virtual_cart')
    {
        return self::getVirtualCart($cartLabel)[$moduleId] ?? null;
    }

    public static function showProcessCheckout($cartLabel = '__virtual_cart')
    {
        $virtualCart = self::getVirtualCart($cartLabel);
        return isset($virtualCart['step']) 
            && app()->request->pathInfo != ltrim(tools()->getUrl($virtualCart['step']), '/');
    }

    public static function getCacheCartKey($cartLabel = '__virtual_cart')
    {
        $userId = tools()->getUser()->id;
        return "{$cartLabel}:{$userId}";
    }
}
