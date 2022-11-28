<?php

namespace app\modules\Codnitive\Cms\actions\Terms;

use app\modules\Codnitive\Core\actions\Action;

class IndexAction extends Action
{
    public function run()
    {
        $this->controller->view->title = __('cms', 'General Terms and Conditions | Bus, Insuranc, Tourism and Museum, Terms');
        return $this->controller->render('/templates/terms/index.phtml');
    }
}
