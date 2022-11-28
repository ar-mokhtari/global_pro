<?php

namespace app\modules\Codnitive\Account\actions;

use app\modules\Codnitive\Account\actions\MainAction;
use app\modules\Codnitive\Account\models\Sales\Order\MyOrder\Grid;
use app\modules\Codnitive\Wallet\models\ChargeForm;

class IndexAction extends MainAction
{
    public function run()
    {
        parent::run();
        // $this->controller->view->params['active_menu'] = Json::encode(['dashboard']);
        $this->controller->view->params['active_menu'] = 'dashboard';
        $this->controller->setBodyClass('account orange dashboard');
        app()->getModule('sales');
        app()->getModule('wallet');
        return $this->controller->render(
            '/account/dashboard.phtml',
            [
                'userIdentity'  => tools()->getUser()->identity,
                'ordersGrid'    => (new Grid)->setLimit(10),
                'formModel'     => new ChargeForm
            ]
        );
    }
}
