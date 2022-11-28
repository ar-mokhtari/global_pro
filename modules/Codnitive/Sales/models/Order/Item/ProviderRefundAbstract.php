<?php 

namespace app\modules\Codnitive\Sales\models\Order\Item;

use app\modules\Codnitive\Sales\models\Order\Item;
use app\modules\Codnitive\Coupon\models\Admin\Used;

abstract class ProviderRefundAbstract
{
    protected $item;

    public function __construct(Item $item = null)
    {
        if ($item instanceof Item) {
            $this->setOrderItem($item);
        }
    }

    public function setOrderItem(Item $item): self
    {
        $this->item = $item;
        return $this;
    }
    
    public function canRefund(\app\modules\Codnitive\Sales\models\Order\Item $item): bool
    {
        // check item ticket_status for showing refund if it's refunded, show refunded message
        // also check order if is completed should show button
        // @todo check for ticket status which if is refunded before return this false
        if ($item->ticket_status == tools()->getOptionIdByValue('Core', 'TicketStatus', 'Refunded', false)) {
            return false;
        }
        return true;
        // $date = (new \DateTime())->setTimezone(new \DateTimeZone(app()->timeZone));
        // $now  = $date->format('Y-m-d\TH:i:s');
        // $orderDate = $item->getOrder()->order_date;
        // return tools()->minutesDiff($orderDate, $now) <= 60 * 24;
    }

    public function calcRefundAmount(): float
    {
        return floatval($this->item->price) * intval($this->item->qty) - $this->_getCouponCodeDiscountAmount();
    }

    public function checkTicketStatusForRefund()
    {
        switch ($this->item->ticket_status) {
            case 101:
                return -100.0;
                break;
            
            case 3:
            case 100:
                return true;
                break;

            default:
                return -30.0;
        }
    }

    public function updateItem(int $itemId, $refundResult)
    {
        return $this;
    }

    public function markItemRefunded(): void
    {
        return;
        // $this->item->ticket_status = tools()->getOptionIdByValue('Core', 'TicketStatus', 'Refunded', false);
        // $this->item->save();
        // $this->item = $this->item->jsonDecodeFields($this->item);
    }

    protected function _getCouponCodeDiscountAmount(): float
    {
        $usedCoupon = (new Used)->loadByOrderid($this->item->getOrder()->id);
        if (!$usedCoupon->id) {
            return 0;
        }
        return (float) $usedCoupon->discount_amount;
    }
}
