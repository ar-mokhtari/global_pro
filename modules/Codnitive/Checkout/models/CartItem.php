<?php

namespace app\modules\Codnitive\Checkout\models;

use devanych\cart\CartItem as BaseCartItem;
use app\modules\Codnitive\Core\helpers\Tools;
// use app\modules\Codnitive\Checkout\components\AvailableQtyException;

class CartItem extends BaseCartItem
{
    const AVAILABLE_QTY_ERROR = 'available_qty_error';
    const EXPIRED_DATE_ERROR  = 'expired_date_error';

    /**
     * @var object $product
     */
    private $product;
    /**
     * @var integer $quantity
     */
    private $quantity;
    /**
     * @var array $params Custom configuration params
     */
    private $params;

    public function __construct($product, $quantity, array $params)
    {
        $this->product = $product;
        // $this->quantity = $quantity;
        $this->setQuantity($quantity);
        $this->params = $params;
    }

    /**
     * Returns the id of the item
     * @return integer
     */
    public function getId()
    {
        return $this->product->{$this->params['productFieldId']};
    }

    /**
     * Returns the price of the item
     * @return integer|float
     */
    public function getPrice()
    {
        return $this->product->{$this->params['productFieldPrice']};
    }

    /**
     * Returns the product, AR model
     * @return object
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Returns the cost of the item
     * @return integer|float
     */
    public function getCost()
    {
        return $this->getPrice() * $this->quantity;
        // return ceil($this->getPrice() * $this->quantity);
    }

    /**
     * Returns the quantity of the item
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Sets the quantity of the item
     * @param integer $quantity
     * @return void
     */
    public function setQuantity($quantity)
    {
        $product = $this->getProduct();
        if (!$product->checkForAvailableQty($quantity)) {
            Tools::registerError(
                self::AVAILABLE_QTY_ERROR, 
                $product->id,
                $product->getUnavailableMessage($quantity)
            );
            $this->quantity = $this->quantity?:0;
            return $this;
        }
        $this->quantity = $quantity;
    }

    public function getRemoveUrl()
    {
        return Tools::getUrl(
            'checkout/cart/remove/id/'.$this->getProduct()->id
        );
    }
}
