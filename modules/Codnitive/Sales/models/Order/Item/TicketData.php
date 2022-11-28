<?php 

namespace app\modules\Codnitive\Sales\models\Order\Item;

use app\modules\Codnitive\Core\models\DynamicModel;

class TicketData extends DynamicModel
{
    protected $_module = 'sales';
    protected $_attributes = ['ticket_provider', 'ticket_number', 'ticket_status', 
        'ticket_id', 'product_data'
    ];
    protected $_rules = [
        'required' => ['ticket_provider', 'ticket_number', 'ticket_status'], 
        'safe' => ['ticket_id', 'product_data'], 
    ];
}
