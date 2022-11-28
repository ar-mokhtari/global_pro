<?php 

namespace app\modules\Codnitive\Checkout\blocks\Process\Success;
use yii\helpers\Json;
use app\modules\Codnitive\Core\blocks\Template;
use app\modules\Codnitive\Sales\models\Order;

abstract class GoogleTagManagerAbstract extends Template
{
    public const PRICE_RATIO = 1000;
    public const EVENT = 'eec.purchase';
    public const OBJECT_NAME = 'ecommerce';
    public const TYPE = 'purchase';

    protected $order;
    protected $_successParams;

    public function __construct(Order $order, array $successParams = [])
    {
        $this->order = $order;
        $this->_successParams = $successParams;
    }

    public function getDataLayer(): string
    {
        return Json::encode([
            'event' => self::EVENT,
            self::OBJECT_NAME => [
                self::TYPE => [
                    'actionField' => $this->getActionField(),
                    'products' => $this->getProducts()
                ]
            ]
        ]);
    }

    public function getActionField()
    {
        $field = [
            'id' => $this->order->id,
            'revenue' => $this->dividePrice($this->order->grand_total),
        ];
        $paymentInfo = $this->order['payment_info'];
        if ($paymentInfo->coupon_code) {
            $field['coupon'] = $this->dividePrice($paymentInfo->discount_amount) . $paymentInfo->coupon_code;
        }
        return $field;
    }

    public function dividePrice(float $price): string
    {
        return tools()->formatNumber($price / self::PRICE_RATIO);
    }

    abstract public function getProducts(): array;
}
