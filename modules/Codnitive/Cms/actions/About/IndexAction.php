<?php

namespace app\modules\Codnitive\Cms\actions\About;

use app\modules\Codnitive\Core\actions\Action;

class IndexAction extends Action
{
    public function run()
    {
        $this->controller->view->title = __('cms', 'About Us | About Company');
        return $this->controller->render('/templates/about/index.phtml');
    }
}
