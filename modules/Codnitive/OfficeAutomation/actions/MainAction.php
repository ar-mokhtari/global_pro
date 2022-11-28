<?php

namespace app\modules\Codnitive\OfficeAutomation\actions;

use app\modules\Codnitive\Core\actions\Action;

class MainAction extends Action
{

    public function run()
    {
//        $this->controller->setBodyClass('hold-transition sidebar-mini');
        $this->controller->layout = '@app/modules/Codnitive/CentralOffice/views/layouts/main';
    }
}
