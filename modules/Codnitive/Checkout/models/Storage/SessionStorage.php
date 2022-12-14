<?php

namespace app\modules\Codnitive\Checkout\models\Storage;

use Yii;
use devanych\cart\storage\CookieStorage as BaseSessionStorage;
use app\modules\Codnitive\Checkout\models\CartItem;

class SessionStorage extends BaseSessionStorage
{
    /**
     * @var array $params Custom configuration params
     */
    private $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return \devanych\cart\models\CartItem[]
     */
    public function load()
    {
        return Yii::$app->session->get($this->params['key'], []);
    }

    /**
     * @param \devanych\cart\models\CartItem[] $items
     * @return void
     */
    public function save(array $items)
    {
        Yii::$app->session->set($this->params['key'], $items);
    }
}
