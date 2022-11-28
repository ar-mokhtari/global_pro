<?php

namespace app\modules\Codnitive\Sales\models\Account\Order\MyOrder;

// use Yii;
use yii\helpers\Html;
use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Core\models\Grid\GridAbstract;
use app\modules\Codnitive\Calendar\models\Persian;

class Grid extends GridAbstract
{
    protected $_modelClass      = '\app\modules\Codnitive\Sales\models\Order';
    protected $_searchModel     = '\app\modules\Codnitive\Sales\models\Account\Order\MyOrder\Grid\Filter';
    protected $_actionsTemplate = '{view}';
    
    public function __construct()
    {
        parent::__construct();
        $this->_sortAttributes = ['id', 'order_number', 'fullname', 'email'/*, 'status'*/, 'grand_total', 
            'order_date', 'payment_method', 'status_label', 'ticket_type'];
        $this->_columns = ['id', 'status', 'grand_total', 'order_date', 
            'billing_data', 'payment_method', 'ticket_type'];
    }

    protected function _prepareDataCollection($columns = [])
    {
        // $collection = $this->_modelObject->prepareCollection($columns);
        $collection = parent::_prepareDataCollection($columns);
        return $collection->andWhere(['customer_id' => Tools::getUser()->id]);
    }

    protected function _prepareColumnsFormat()
    {
        return [
            // [
            //     'attribute' => 'id',
            //     'label' => __('sales', 'ID')
            // ],
            [
                'attribute' => 'order_number',
                'contentOptions' => ['class' => 'text-center col-order-number'],
                'label' => __('sales', 'Order #'),
                'format' => 'html',
                'value' => function ($model) {
                    if (!tools()->isAdmin()) {
                        return $model->order_number;
                    }
                    $url = tools()->getUrl('admin/order', ['id' => $model->id]);
                    return <<<LINK
                    <a href="$url">$model->order_number</a>
LINK;
                }
            ],
            [
                'attribute' => 'fullname',
                'label' => __('sales', 'Full Name'),
                'contentOptions' => ['class' => 'force-text-right col-name'],
            ],
            [
                'attribute' => 'email',
                'label' => __('sales', 'Email'),
                'contentOptions' => ['class' => 'col-email font-en'],
                'headerOptions'  => ['class' => 'col-email-header'],
            ],
            [
                'attribute' => 'order_date',
                'label' => __('sales', 'Order Date'),
                'contentOptions' => ['class' => 'text-center col-date'],
                'format' => 'html',
                'value' => function ($model) {
                    $dateParts = explode(' ', tools()->getFormattedDate($model->order_date, 'Y-m-d H:i'));
                    return str_replace('-', '/', (new Persian)->getDate($dateParts[0])) . '&nbsp;' . $dateParts[1];
                }
            ],
            [
                'attribute' => 'grand_total',
                'label' => __('sales', 'Grand Total'),
                'contentOptions' => ['class' => 'force-text-right col-total'],
                'format' => 'html',
                'value' => function ($model) {
                    return tools()->formatRial($model->grand_total);
                },
            ],
            [
                'attribute' => 'ticket_type',
                'label' => __('template', 'Ticket Type'),
                'contentOptions' => ['class' => 'col-ticket-type'],
                'value' => function ($model) {
                    return __('template', $model->ticket_type);
                },
            ],
            [
                'attribute' => 'payment_method',
                'label' => __('sales', 'Payment Method'),
                'contentOptions' => ['class' => 'col-payment-method'],
                'value' => function ($model) {
                    $method = $model->payment_method;
                    if (!class_exists("app\modules\Codnitive\\$method\models\Gateway")) {
                        return (string) $method;
                    }
                    app()->getModule(strtolower($method));
                    return getObject("app\modules\Codnitive\\$method\models\Gateway")->getTitle();
                },
            ],
            [
                'attribute' => 'status_label',
                'label' => __('sales', 'Status'),
                'contentOptions' => ['class' => 'col-status'],
                // 'value' => function ($model) {
                //     return Tools::getOptionValue('Sales', 'OrderStatus', $model->status);
                // },
            ],
        ];
    }

    protected function _getActionButtons()
    {
        return [
            'view' => function ($url, $model) {
                $isAdminPanel = intval(tools()->showInAdminPanel());
                $viewBtn = '<span class="btn btn-info btn-sm fz-12 my-1 view-order-details" data-admin="'.$isAdminPanel.'">
                    <span class="view">'.__('template', 'View').'</span>
                    <span class="close-view d-none">'.__('template', 'Close').'</span>
                </span>';
                return Html::a($viewBtn, $url, [
                    'title' => __('template', 'View'),
                ]);
            }
        ];
    }

    protected function _getActionUrls($action, $model, $key, $index)
    {
        return 'javascript:;';
        return $model->getOrderUrl();
        // return Tools::getUrl(
        //     'account/sales/order',
        //     ['id' => $key]
        // );
    }
}
