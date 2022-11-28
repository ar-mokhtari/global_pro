<?php

namespace app\modules\Codnitive\Admin\actions\Ajax;

/**
 * Method which calls with ajax to get order history calendar
 * 
 * @route   admin/admin/ajax/getTodayOrders
 */
class GetTodayOrdersAction extends \app\modules\Codnitive\Core\actions\Action
{
    
    public function run()
    {
        app()->getModule(\app\modules\Codnitive\Reports\Module::MODULE_ID);
        $response = [
            [
                'element' => "#dashboard_today_orders",
                'type'    => 'html',
                'content' => $this->controller->renderAjax(
                    '/templates/dashboard/_dashboard_today_orders.phtml', 
                    [
                        'block' => new \app\modules\Codnitive\Admin\blocks\TodayOrders, 
                    ]
                )
            ],
        ];

        return $this->responseJson($response);
    }

}
