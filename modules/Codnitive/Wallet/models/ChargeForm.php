<?php 

namespace app\modules\Codnitive\Wallet\models;

use app\modules\Codnitive\Core\models\DynamicModel;

class ChargeForm extends DynamicModel
{
    protected $_module = 'wallet';
    protected $_attributes = ['charge_amount'];
    protected $_rules = [
        'required' => ['charge_amount'],
        'integer'  => ['charge_amount'], 
    ];
    protected $_labels = [
        'charge_amount'  => 'Charge Amount',
    ];
}
