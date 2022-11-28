<?php

namespace app\modules\Codnitive\Wallet\actions;

use app\modules\Codnitive\Core\actions\Action;

class MainAction extends Action
{
    public function run()
    {
        $this->controller->layout = '@app/modules/Codnitive/Account/views/layouts/main';
    }
}
