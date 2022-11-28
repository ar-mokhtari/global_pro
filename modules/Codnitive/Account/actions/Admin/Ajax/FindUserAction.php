<?php

namespace app\modules\Codnitive\Account\actions\Admin\Ajax;

use app\modules\Codnitive\Account\models\User;

/**
 * Method which calls with ajax to get list of data providers for selected product
 * 
 * @route   admin/account/ajax/findUser
 */
class FindUserAction extends \app\modules\Codnitive\Core\actions\Action
{

    public function run()
    {
        $searchQuery = $this->_getRequest()->get('query');
        $response = empty($searchQuery) ? [] : (new User)->getUserSearchList($searchQuery);
        return $this->responseJson($response);
    }
}
