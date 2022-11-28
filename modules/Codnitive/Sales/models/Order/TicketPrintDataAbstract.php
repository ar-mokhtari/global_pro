<?php 

namespace app\modules\Codnitive\Sales\models\Order;

use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Core\models\DynamicModel;
use app\modules\Codnitive\PriceRule\models\Admin\Rule;
use app\modules\Codnitive\PriceRule\models\Admin\PriceRuleInterface;

abstract class TicketPrintDataAbstract extends DynamicModel 
    implements \app\modules\Codnitive\Sales\models\Order\TicketPrintDataInterface
{
    protected $order;
    protected $priceRuleObject;
    protected $priceRuleData = [];

    public function setOrder(Order $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function setPriceRuleObject(PriceRuleInterface $priceRuleObject): self
    {
        $this->priceRuleObject = $priceRuleObject;
        return $this;
    }

    public function setPriceRuleData(array $priceRuleData): self
    {
        $this->priceRuleData = $priceRuleData;
        return $this;
    }

    public function getTicketGrandTotal(): float
    {
        if (!empty($this->priceRuleData)) {
            $this->priceRuleObject->setMatchedRule(new Rule($this->priceRuleData));
            return $this->priceRuleObject->getPriceChange($this->final_price);
        }
        return $this->final_price;
    }
}