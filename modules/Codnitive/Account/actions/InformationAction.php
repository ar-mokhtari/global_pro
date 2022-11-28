<?php

namespace app\modules\Codnitive\Account\actions;

use app\modules\Codnitive\Account\actions\MainAction;

class InformationAction extends MainAction
{
    public function run(/*$id = null*/)
    {
        parent::run(/*$id*/);
        return $this->controller->render('/account/information');
    }
}
