<?php

namespace app\modules\Codnitive\Checkout\models;

use Yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;
use devanych\cart\Cart as BaseCart;
use app\modules\Codnitive\Checkout\models\CartItem;
use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Catalog\models\EntityFactory;

class Cart extends BaseCart
{
    /**
     * @var string $storageClass
     */
    public $storageClass = 'devanych\cart\storage\SessionStorage';

    /**
     * @var string $calculatorClass
     */
    public $calculatorClass = 'devanych\cart\calculators\SimpleCalculator';

    /**
     * @var array $params Custom configuration params
     */
    public $params = [];

    /**
     * @var array $defaultParams
     */
    private $defaultParams = [
        'key' => 'cart',
        'expire' => 604800,
        'productClass' => 'app\model\Product',
        'productFieldId' => 'id',
        'productFieldPrice' => 'price',
    ];

    /**
     * @var CartItem[]
     */
    private $items;

    /**
     * @var \devanych\cart\storage\StorageInterface
     */
    private $storage;

    /**
     * @var \devanych\cart\calculators\CalculatorInterface
     */
    private $calculator;

    public $billingInfo;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->params = array_merge($this->defaultParams, $this->params);

        if (!class_exists($this->params['productClass'])) {
            throw new InvalidConfigException('productClass `' . $this->params['productClass'] . '` not found');
        }
        if (!class_exists($this->storageClass)) {
            throw new InvalidConfigException('storageClass `' . $this->storageClass . '` not found');
        }
        if (!class_exists($this->calculatorClass)) {
            throw new InvalidConfigException('calculatorClass `' . $this->calculatorClass . '` not found');
        }

        $this->storage = new $this->storageClass($this->params);
        $this->calculator = new $this->calculatorClass();
    }

    /**
     * Add an item to the cart
     * @param object $product
     * @param integer $quantity
     * @return void
     */
    public function add($product, $quantity)
    {
        $this->loadItems();
        if (isset($this->items[$product->{$this->params['productFieldId']}])) {
            $this->plus($product->{$this->params['productFieldId']}, $quantity);
        } else {
            $this->items[$product->{$this->params['productFieldId']}] = new CartItem($product, $quantity, $this->params);
            ksort($this->items, SORT_NUMERIC);
            $this->saveItems();
        }
    }

    /**
     * Adding item quantity in the cart
     * @param integer $id
     * @param integer $quantity
     * @return void
     */
    public function plus($id, $quantity)
    {
        $this->loadItems();
        if (isset($this->items[$id])) {
            $this->items[$id]->setQuantity($quantity + $this->items[$id]->getQuantity());
        }
        $this->saveItems();
    }

    /**
     * Change item quantity in the cart
     * @param integer $id
     * @param integer $quantity
     * @return void
     */
    public function change($id, $quantity)
    {
        $this->loadItems();
        if (isset($this->items[$id])) {
            $this->items[$id]->setQuantity($quantity);
        }
        $this->saveItems();
    }

    /**
     * Removes an items from the cart
     * @param integer $id
     * @return void
     */
    public function remove($id)
    {
        $this->loadItems();
        if (array_key_exists($id, $this->items)) {
            unset($this->items[$id]);
        }
        $this->saveItems();
    }

    /**
     * Removes all items from the cart
     * @return void
     */
    public function clear()
    {
        $this->items = [];
        $this->saveItems();
    }

    /**
     * Returns all items from the cart
     * @return CartItem[]
     */
    public function getItems()
    {
        $this->loadItems();
        return $this->items;
    }

    /**
     * Returns an item from the cart
     * @param integer $id
     * @return CartItem
     */
    public function getItem($id)
    {
        $this->loadItems();
        return isset($this->items[$id]) ? $this->items[$id] : null;
    }

    /**
     * Returns ids array all items from the cart
     * @return array
     */
    public function getItemIds()
    {
        $this->loadItems();
        $items = [];
        foreach ($this->items as $item) {
            $items[] = $item->getId();
        }
        return $items;
    }

    /**
     * Returns total cost all items from the cart
     * @return integer
     */
    public function getTotalCost()
    {
        $this->loadItems();
        return $this->calculator->getCost($this->items);
    }

    /**
     * Returns total count all items from the cart
     * @return integer
     */
    public function getTotalCount()
    {
        $this->loadItems();
        return $this->calculator->getCount($this->items);
    }

    /**
     * Load all items from the cart
     * @return void
     */
    private function loadItems()
    {
        if ($this->items === null) {
            $this->items = $this->storage->load();
        }
    }

    /**
     * Save all items to the cart
     * @return void
     */
    private function saveItems()
    {
        $this->storage->save($this->items);
    }

    public function getClearUrl()
    {
        return Tools::getUrl(
            'checkout/cart/clear'
        );
    }

    public function getUpdateUrl()
    {
        return Tools::getUrl(
            'checkout/cart/update'
        );
    }

    public function getSubmitOrderUrl()
    {
        return Tools::getUrl(
            'checkout/cart/submitOrder'
        );
    }

    public function checkItemsAvailability()
    {
        $session  = Yii::$app->session;
        $session->remove(CartItem::EXPIRED_DATE_ERROR);
        $session->remove(CartItem::AVAILABLE_QTY_ERROR);
        // $today    = Tools::getWhenDates('Today')['end_date'];
        foreach ($this->getItems() as $item) {
            if ($this->_checkDateAvailability($item/* , $today */)) {
                $this->_checkQtyAvailability($item);
            }
        }
        return $this;
    }

    protected function _checkDateAvailability($item/* , $date */)
    {
        $product = $item->getProduct();
        $entity  = (new EntityFactory($product->entity_type, $product->entity_id))->load();
        $expiredCondition = $entity->hasAttribute('start_date')
            && Tools::dateExpired($entity->start_date);
        if ($expiredCondition) {
            Tools::registerError(
                CartItem::EXPIRED_DATE_ERROR, 
                $product->id,
                sprintf('%s has been expired', $product->getName(true))
            );
            return false;
        }
        return true;
    }

    protected function _checkQtyAvailability($item)
    {
        $product  = $item->getProduct();
        $quantity = $item->getQuantity();
        if (!$product->checkForAvailableQty($quantity)) {
            Tools::registerError(
                CartItem::AVAILABLE_QTY_ERROR, 
                $product->id,
                $product->getUnavailableMessage($quantity)
            );
            return false;
        }
        return true;
    }

    public function checkItemsAvailabilityErrors()
    {
        $session        = Yii::$app->session;
        $expiredErrors  = $session->get(CartItem::EXPIRED_DATE_ERROR) ?? [];
        $qtyErrors      = $session->get(CartItem::AVAILABLE_QTY_ERROR) ?? [];

        if (empty($expiredErrors) && empty($qtyErrors)) {
            return true;
        }
        $session->remove(CartItem::EXPIRED_DATE_ERROR);
        $session->remove(CartItem::AVAILABLE_QTY_ERROR);

        $allErrors = array_merge($expiredErrors, $qtyErrors);
        $message   = '';
        foreach ($allErrors as $errors) {
            $message .= implode("<br>\n", $errors) . "<br>\n";
        }

        $session->setFlash('danger', $message);
        return false;
    }
}
