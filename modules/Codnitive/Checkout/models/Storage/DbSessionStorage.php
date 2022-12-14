<?php

namespace app\modules\Codnitive\Checkout\models\Storage;

use Yii;
use yii\db\Query;
use devanych\cart\storage\DbSessionStorage as BaseDbSessionStorage;
use app\modules\Codnitive\Checkout\models\CartItem;

class DbSessionStorage extends BaseDbSessionStorage
{
    /**
     * @var string $string Table name
     */
    private $table = '{{%cart_items}}';

    /**
     * @var array $params Custom configuration params
     */
    private $params;

    /**
     * @var \yii\db\Connection $db
     */
    private $db;

    /**
     * @var integer $userId
     */
    private $userId;

    /**
     * @var SessionStorage $sessionStorage
     */
    private $sessionStorage;

    public function __construct(array $params)
    {
        $this->params = $params;
        $this->db = Yii::$app->db;
        $this->userId = Yii::$app->user->id;
        $this->sessionStorage = new SessionStorage($this->params);
    }

    /**
     * @return CartItem[]
     */
    public function load()
    {
        if (Yii::$app->user->isGuest) {
            return $this->sessionStorage->load();
        }
        $this->moveItems();
        return $this->loadDb();
    }

    /**
     * @param CartItem[] $items
     * @return void
     */
    public function save(array $items)
    {
        if (Yii::$app->user->isGuest) {
            $this->sessionStorage->save($items);
        } else {
            $this->moveItems();
            $this->saveDb($items);
        }
    }

    /**
     *  Moves all items from session storage to database storage
     * @return void
     */
    private function moveItems()
    {
        if ($sessionItems = $this->sessionStorage->load()) {
            // $items = array_merge($this->loadDb(), $sessionItems); // ORIG
            // $items = ($this->loadDb() + $sessionItems);
            $dbItems = $this->loadDb();
            foreach ($sessionItems as $item) {
                $itemId = $item->getId();
                if ($dbItems[$itemId]) {
                    $quantity = floatval($dbItems[$itemId]->getQuantity()) 
                              + floatval($item->getQuantity());
                    $dbItems[$itemId]->setQuantity($quantity);
                }
            }
            $this->saveDb($dbItems);
            $this->sessionStorage->save([]);
        }
    }

    /**
     * Load all items from the database
     * @return CartItem[]
     */
    private function loadDb()
    {
        $rows = (new Query())
            ->select('*')
            ->from($this->table)
            ->where(['user_id' => $this->userId])
            ->all();

        $items = [];
        foreach ($rows as $row) {
            $product = $this->params['productClass']::find()
                ->where([$this->params['productFieldId'] => $row['product_id']])
                ->limit(1)
                ->one();
            if ($product) {
                $items[$product->{$this->params['productFieldId']}] = new CartItem($product, $row['quantity'], $this->params);
            }
        }
        return $items;
    }

    /**
     * Save all items to the database
     * @param CartItem[] $items
     * @return void
     */
    private function saveDb(array $items)
    {
        $this->db->createCommand()->delete($this->table, ['user_id' => $this->userId])->execute();

        $this->db->createCommand()->batchInsert(
            $this->table,
            ['user_id', 'product_id', 'quantity'],
            array_map(function (CartItem $item) {
                return [
                    'user_id' => $this->userId,
                    'product_id' => $item->getId(),
                    'quantity' => $item->getQuantity(),
                ];
            }, $items)
        )->execute();
    }
}
