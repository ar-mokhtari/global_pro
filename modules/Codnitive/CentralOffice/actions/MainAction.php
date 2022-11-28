<?php

namespace app\modules\Codnitive\CentralOffice\actions;

class MainAction extends \app\modules\Codnitive\Core\actions\Action
{

    public function run()
    {
        $this->controller->setBodyClass('hold-transition sidebar-mini');
        $this->controller->layout = '@app/modules/Codnitive/CentralOffice/views/layouts/main';
    }
}
