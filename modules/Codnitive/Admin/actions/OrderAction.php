<?php

namespace app\modules\Codnitive\Admin\actions;

use app\modules\Codnitive\Admin\actions\MainAction;
use app\modules\Codnitive\Sales\models\Order;

class OrderAction extends MainAction
{
    public function run()
    {
        app()->getModule('sales');
        parent::run();
        $this->controller->setBodyClass($this->controller->getBodyClass() . ' order details');
        $this->controller->view->params['breadcrumbs'][1] = [
            'label' => __('sales', 'Orders'),
            'url' => tools()->getPreviousUrl(),
            // 'url' => tools()->getUrl('admin/orders/', [], false),
        ];
        $orderId = $this->_getRequest()->get('id');
        return $this->controller->render(
            '/templates/orders/details.phtml', 
            ['order' => (new Order)->loadOne($orderId)]
        );
    }
}
