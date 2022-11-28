<?php 

namespace app\modules\Codnitive\Sales\models\Order;

use app\modules\Codnitive\Core\models\DynamicModel;

class BillingData extends DynamicModel
{
    protected $_module = 'sales';
    protected $_attributes = ['firstname', 'lastname', 'cellphone', 'email', 'city',
        'address', 'extra_data', 'template'
    ];
    protected $_rules = [
        'required' => ['firstname', 'lastname', 'cellphone'], 
        'safe' => ['city', 'address', 'extra_data', 'template', 'email']
    ];
}