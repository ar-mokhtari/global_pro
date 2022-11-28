<?php 

namespace app\modules\Codnitive\Sales\models\Order;

use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\PriceRule\models\Admin\PriceRuleInterface;

interface TicketPrintDataInterface
{
    public function setOrder(Order $order);
    public function setPriceRuleObject(PriceRuleInterface $priceRuleObject);
    public function setPriceRuleData(array $priceRuleData);
    public function getTicketGrandTotal(): float;
}