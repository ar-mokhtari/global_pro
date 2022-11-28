<?php

namespace app\modules\Codnitive\Admin\actions;

// use yii\helpers\Url;
// use yii\helpers\Json;
use app\modules\Codnitive\Admin\actions\MainAction;
use app\modules\Codnitive\Admin\models\Orders\Grid;

class OrdersAction extends MainAction
{
    public function run()
    {
        parent::run();
        app()->getModule('sales');
        $this->controller->view->title = __('admin', 'Orders List');
        $this->controller->setBodyClass($this->controller->getBodyClass() . ' orders list');

        $this->controller->view->params['breadcrumbs'][10] = __('admin', 'Orders');
        // $this->controller->view->params['active_menu'] = Json::encode(['orders']);
        $this->controller->view->params['active_menu'] = 'orders';
        return $this->controller->render('/templates/orders/list.phtml', ['ordersGrid' => new Grid]);
    }
}
