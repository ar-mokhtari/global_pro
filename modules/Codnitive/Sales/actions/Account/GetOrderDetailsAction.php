<?php

namespace app\modules\Codnitive\Sales\actions\Account;

// use yii\helpers\Json;
use app\modules\Codnitive\Sales\actions\MainAction;
use app\modules\Codnitive\Sales\models\Order;
// use app\modules\Codnitive\Core\helpers\Tools;

class GetOrderDetailsAction extends MainAction
{
    public function run()
    {
        return $this->responseJson($this->_getTemplates());
    }

    protected function _getTemplates()
    {
        $templates = [];
        $order = (new Order)->loadOne((int) $this->_getRequest()->post('id'));
        $count = count($order->getItems());
        // $showPrint = true;
        // $lastTicketId = null;
        foreach ($order->getItems() as $key => $item) {
            // $showPrint = $item->ticket_id !== $lastTicketId;
            // $lastTicketId = $item->ticket_id;
            $templates[$key] = $this->controller->renderAjax(
                $item->product_data['template'], 
                [
                    'order' => $order, 
                    'item' => $item, 
                    'key' => $key, 
                    'count' => $count,
                    // 'showPrint' => $showPrint
                ]
            );
        }
        // app()->session->remove('__flight_show_print_btn');
        return $templates;
    }
}
