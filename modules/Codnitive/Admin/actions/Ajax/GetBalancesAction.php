<?php

namespace app\modules\Codnitive\Admin\actions\Ajax;

/**
 * Method which calls with ajax to get order history calendar
 * 
 * @route   admin/admin/ajax/getBalances
 */
class GetBalancesAction extends \app\modules\Codnitive\Core\actions\Action
{
    
    public function run()
    {
        $response = [
            [
                'element' => "#dashboard_apis_balance",
                'type'    => 'html',
                'content' => $this->controller->renderAjax(
                    '/templates/dashboard/_dashboard_api_balance.phtml', 
                    [
                        'block' => new \app\modules\Codnitive\Admin\blocks\Apis, 
                    ]
                )
            ],
        ];

        return $this->responseJson($response);
    }

}
