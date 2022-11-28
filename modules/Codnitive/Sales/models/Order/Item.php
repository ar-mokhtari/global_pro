<?php

namespace app\modules\Codnitive\Sales\models\Order;

use Yii;
use app\modules\Codnitive\Core\models\ActiveRecord;
// use app\modules\Codnitive\Core\helpers\Rules;
// use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Sales\models\Order;
// use app\modules\Codnitive\Sales\models\Order\Item\RefundInterface;

class Item extends ActiveRecord /*implements RefundInterface*/
{
    // protected $_arrayFields = ['product_data'];
    protected $_parentObjectField = 'order_id';

    protected $order;

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{sales_order_item}}';
    }

    public function rules()
    {
        $rules = [
            [['order_id', 'merchant_id', 'name', 'price', 'qty', 'ticket_type', 
                'product_data', 'ticket_provider'
            ], 'safe'],
            [['order_id', 'merchant_id', 'name', 'price', 'qty', 'ticket_type',
                'ticket_provider'
            ], 'required']
        ];
        return $rules;
    }

    public function setOrderId(int $orderId): self
    {
        $this->_parentObjectId = $orderId;
        return $this;
    }

    public function saveOrderItem(
        \app\modules\Codnitive\Sales\models\Order $order, 
        \app\modules\Codnitive\Sales\models\Order\Item $item
    ) {
        $item->order_id = $order->id;
        if (!$item->validate()) {
            throw new \Exception(__('template', 'Order item data are not valid.'));
        }
        return $item->save();
    }

    public function getCollection($fieldsToSelect = ['*'], bool $asArray = false, string $arrayKeyField = 'id')
    {
        $this->removeCollectionLimit();
        return parent::getCollection($fieldsToSelect);
    }

    public function getOrder()
    {
        if (empty($this->order)) {
            $this->order = (new Order)->loadOne($this->order_id);
        }
        return $this->order;
    }
    
    public function canRefund(): bool
    {
        if (empty($this->ticket_provider)) {
            return false;
        }
        return $this->_getProviderRefundObject()->canRefund($this);
    }

    /**
     * Codes:
     * 
     * -100.0 item refunded before
     * -10.0  item is not refundable
     * -20.0  refund request rejected
     * -1.0   unknown error occurred
     */
    public function refund(): array
    {
        app()->getModule('sales');
        if (!$this->canRefund()) {
            return [
                'status' => false,
                'message' => __('sales', 'Unfortunately you can not refund this item anymore.')
            ];
        }

        $providerRefund = $this->_getProviderRefundObject()->setOrderItem($this)->refund();
        $this->_getProviderRefundObject()->updateItem($this->id, $providerRefund);
        switch ($providerRefund) {
            case -100.0:
                $this->_changeToRefundStatus();
                return [
                    'status' => false,
                    'message' => __('sales', 'This item refunded before.')
                ];
                break;

            case -10.0:
                return [
                    'status' => false,
                    'message' => __('sales', 'This item is not refundable, or you can not refund this item online.')
                ];
                break;

            case -20.0:
                return [
                    'status' => false,
                    'message' => __('sales', 'Your refund request rejected.')
                ];
                break;

            case -30.0:
                return [
                    'status' => false,
                    'message' => __('sales', 'This ticket not issued or confirm yet, so you can not refund it.')
                ];
                break;

            case -1.0:
                return [
                    'status' => false,
                    'message' => __('sales', 'An error occurred when try to refund item, please try again.')
                ];
                break;

        }

        // @todo in future we can use payment method gateway or specific bank api
        // to refund money cash
        $wallet = getObject('\app\modules\Codnitive\Wallet\models\Gateway');
        $wallet->setUserId(tools()->getUser()->id);
        $refundStatus = $wallet->refundAmount(
            $providerRefund['refund_amount'], 
            $this->getOrder()->getOrderNumber(), 
            $this->ticket_id,
            $this->getOrder()->customer_id
        );
        if (!$refundStatus) {
            return [
                'status' => false,
                'message' => __('template', 'An error occurred on refund ticket money to credit.')
            ];
        }
        // $this->_getProviderRefundObject()->updateItem($this->id, $providerRefund['refund_result']);
        $this->_changeToRefundStatus();
        return [
            'status' => true,
            'message' => __(
                'template', 
                '{refund_amount} was refunded to your account.', 
                ['refund_amount' => tools()->formatRial($providerRefund['refund_amount'])]
            )
        ];
    }

    protected function _changeToRefundStatus(): void
    {
        $thisObject = $this->jsonDecodeFields($this);
        $this->ticket_status = tools()->getOptionIdByValue('Core', 'TicketStatus', 'Refunded', false);
        $this->setAttributes($thisObject);
        $this->save();
        if ($this->getOrder()->getItemsCount() == $this->getOrder()->getRefundedItemsCount()) {
            $this->getOrder()->setOrderRefunded();
            $this->getOrder()->save();
        }
    }

    protected function _getProviderRefundObject()
    {
        $provider = app()->getModule(strtolower($this->ticket_provider))->getModuleName();
        return getObject("\app\modules\Codnitive\\$provider\models\Refund", [$this]);
    }

    public function changeTicketStatus(string $status): self
    {
        $this->ticket_status = (int) tools()->getOptionIdByValue('Core', 'TicketStatus', $status, false);
        return $this;
    }

}
