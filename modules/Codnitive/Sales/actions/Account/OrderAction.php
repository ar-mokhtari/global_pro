<?php

namespace app\modules\Codnitive\Sales\actions\Account;

use app\modules\Codnitive\Sales\actions\MainAction;
use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Core\helpers\Tools;

class OrderAction extends MainAction
{
    public function run()
    {
        parent::run();
        $label  = __('sales', 'Orders');
        $action = 'list';
        // if (boolval($this->_getRequest()->get('received'))) {
        //     $label  = 'Received Orders';
        //     $action = 'received';
        // }
        $this->controller->view->params['breadcrumbs'][1] = [
            'label' => $label,
            'url' => [Tools::getUrl('account/sales/'.$action, [], false)],
        ];
        $orderId = $this->_getRequest()->get('id');
        return $this->controller->render(
            '/account/order', 
            ['order' => (new Order)->loadOne((int) $orderId)]
        );
    }
}
