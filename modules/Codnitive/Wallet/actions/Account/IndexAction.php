<?php

namespace app\modules\Codnitive\Wallet\actions\Account;

// use yii\helpers\Json;
use app\modules\Codnitive\Wallet\actions\MainAction;
use app\modules\Codnitive\Wallet\models\ChargeForm;
use app\modules\Codnitive\Wallet\models\Account\Transaction\Grid;

class IndexAction extends MainAction
{
    public function run()
    {
        parent::run();
        // unset($this->controller->view->params['breadcrumbs'][1]);
        // $this->controller->view->params['active_menu'] = Json::encode(['wallet']);
        $this->controller->view->params['active_menu'] = 'wallet';
        return $this->controller->render('/templates/account/index.phtml', [
            'transactionGrid' => new Grid,
            'formModel' => new ChargeForm
        ]);
    }
}
