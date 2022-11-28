<?php

namespace app\modules\Codnitive\Sales\actions\Account;

// use yii\helpers\Url;
// use yii\helpers\Json;
use app\modules\Codnitive\Sales\actions\MainAction;
use app\modules\Codnitive\Sales\models\Account\Order\MyOrder\Grid;

class ListAction extends MainAction
{
    public function run()
    {
        parent::run();
        // unset($this->controller->view->params['breadcrumbs'][1]);
        // $this->controller->view->params['active_menu'] = Json::encode(['orders']);
        $this->controller->view->params['active_menu'] = 'orders';
        return $this->controller->render('/account/list', ['orderGrid' => new Grid]);
    }
}
