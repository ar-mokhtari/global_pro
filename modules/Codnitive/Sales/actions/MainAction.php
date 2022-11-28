<?php

namespace app\modules\Codnitive\Sales\actions;

use app\modules\Codnitive\Core\actions\Action;

class MainAction extends Action
{
    public function run()
    {
        // if (/*$eventId && */!$this->_event->id) {
            // if ($this->_requestEvent && !$this->_event->id) {
            //     $this->controller->setFlash('danger', 'This event not exists.');
            // }
            // $this->controller->view->params['breadcrumbs'][1] = [
            //     'label' => 'Sales',
            //     'url' => [Tools::getUrl('account/event/list', [], false)],
            // ];
        $this->controller->layout = '@app/modules/Codnitive/Account/views/layouts/main';
    }
}
