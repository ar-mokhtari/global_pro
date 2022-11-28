<?php 

namespace app\modules\Codnitive\Sales\models\Order;

use app\modules\Codnitive\Core\models\DynamicModel;

class PaymentInfo extends DynamicModel
{
    protected $_module = 'sales';
    protected $_attributes = ['transaction_number', 'trace_number', 'coupon_code', 'discount_amount'];
    protected $_rules = [
        'required' => ['transaction_number', 'trace_number'], 
        'number' => ['discount_amount'],  
    ];
    protected $_fieldRules = [
        'coupon_code' => [
            'rule'      => 'match', 
            'options'   => [
                'pattern' => \app\modules\Codnitive\Coupon\models\Admin\Code::CODE_PATTERN,
                'skipOnEmpty' => true
            ]
        ],
    ];
}