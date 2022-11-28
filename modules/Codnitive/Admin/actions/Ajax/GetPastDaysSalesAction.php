<?php

namespace app\modules\Codnitive\Admin\actions\Ajax;

use app\modules\Codnitive\Reports\models\PastDaysOrders;

/**
 * Method which calls with ajax to get order history calendar
 * 
 * @route   admin/admin/ajax/getPastDays
 */
class GetPastDaysSalesAction extends \app\modules\Codnitive\Core\actions\Action
{
    
    public function run()
    {
        app()->getModule(\app\modules\Codnitive\Reports\Module::MODULE_ID);
        $response = [
            [
                'element' => "#dashboard_past_days_sales",
                'type'    => 'html',
                'content' => $this->controller->renderAjax(
                    '/templates/dashboard/_dashboard_past_days_sales.phtml', 
                    [
                        'block' => new \app\modules\Codnitive\Admin\blocks\PastDaysSales(
                            min(PastDaysOrders::MAX_DAYS, intval($this->_getRequest()->get('days')))
                        ), 
                    ]
                )
            ],
        ];

        return $this->responseJson($response);
    }

}
