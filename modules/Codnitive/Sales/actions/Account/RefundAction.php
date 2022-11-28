<?php

namespace app\modules\Codnitive\Sales\actions\Account;

// use yii\helpers\Json;
use app\modules\Codnitive\Sales\actions\MainAction;
use app\modules\Codnitive\Sales\models\Order\Item;

class RefundAction extends MainAction
{
    public function run()
    {
        $orderItemId = tools()->stripEscapeRequest(app()->getRequest())->get('id');
        $item = (new Item)->loadOne(intval($orderItemId));
        $refundResult = $item->refund();
        
        $flashMode = $refundResult['status'] ? 'success' : 'warning';
        $this->setFlash($flashMode, $refundResult['message']);
        return $this->controller->redirect(tools()->getPreviousUrl());
    }
}
