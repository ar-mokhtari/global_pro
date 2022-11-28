<?php

namespace app\modules\Codnitive\Admin\models;

use yii\helpers\Json;
use app\modules\Codnitive\Core\models\ActiveRecord;

class Order extends ActiveRecord
{
    // protected $_arrayFields = ['billing_data', 'payment_info'];

    public $order_number;
    public $fullname;
    public $email;
    public $status_label;
    public $ticket_type;
    public $cellphone;
    
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{sales_order}}';
    }

    public function afterFind()
    {
        // $billingData     = Json::decode($this->getAttributes()['billing_data']);
        $billingData     = $this->getAttributes()['billing_data'];
        if (is_string($billingData) && tools()->isJson($billingData)) {
            $billingData = Json::decode($billingData);
        }
        $this->order_number = $this->getOrderNumber();
        $this->fullname     = $billingData['fullname'] ?? "{$billingData['firstname']} {$billingData['lastname']}";
        $this->email        = $billingData['email'] ?? '';
        $this->status_label = tools()->getOptionValue('Sales', 'OrderStatus', $this->status);
        $this->cellphone     = $billingData['cellphone'] ?? '';
    }

    public function rules()
    {
        $rules = [
            [['customer_id', /*'merchant_id', */'status', 'grand_total', 'order_date',
                'ticket_type', 'payment_info', 'billing_data', 'payment_method', 'cellphone'
            ], 'safe'],
        ];
        return $rules;
    }

    protected function _prepareCollection($fieldsToSelect = ['*'])
    {
        $columns = [
            'sales_order.*',
            'sales_order_item.order_id',
            'sales_order_item.ticket_type',
            // 'user.id AS user_id',
            // 'user.username',
        ];
        $collection = parent::_prepareCollection($columns);
        // $collection = $collection->leftJoin(
        //     'user', 
        //     'user.id = sales_order.customer_id'
        // );
        $collection = $collection->leftJoin(
            'sales_order_item', 
            'sales_order_item.order_id = sales_order.id'
        );
        // ->groupBy(['sales_order.id']);
        return $collection;
    }

    public function getOrderNumber($url = false, $orderId = 0)
    {
        $orderId = $orderId ?: $this->id;
        $orderNumber = sprintf('%012d', $orderId);
        // $orderNumber = sprintf('1%011d', $orderId);
        return $orderNumber;
        // if (!tools()->isGuest() && $url) {
        //     $orderNumber = '<a href="'.$this->getOrderUrl($orderId).'">'.$orderNumber.'</a>';
        // }
        // return $orderNumber;
    }

}
