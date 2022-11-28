<?php

namespace app\modules\Codnitive\Template\actions;

class IndexAction extends \app\modules\Codnitive\Core\actions\Action
{
    public function run()
    {
        $this->controller->setBodyClass('homepage');
        $this->controller->setBodyId('homepage');
        $this->controller->view->params['active_menu'] = 'home';
//        $this->controller->setHeaderBottom('home/slider.phtml');
        return $this->controller->render('home.phtml');
    }
}
