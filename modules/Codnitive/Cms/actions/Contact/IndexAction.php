<?php

namespace app\modules\Codnitive\Cms\actions\Contact;

use app\modules\Codnitive\Core\actions\Action;

class IndexAction extends Action
{
    public function run()
    {
        $this->controller->view->title = __('cms', 'Contact Us | Contact with us or send a message');
        return $this->controller->render('/templates/contact/index.phtml');
    }
}
