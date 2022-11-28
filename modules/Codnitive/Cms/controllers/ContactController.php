<?php

namespace app\modules\Codnitive\Cms\controllers;

use app\modules\Codnitive\Template\controllers\PageController;

class ContactController extends PageController
{
    protected $_baseActionsPath = 'app\modules\Codnitive\Cms\actions\Contact';
    protected $_actions = [
        'index' => ['get', 'post'],
    ];
    protected $_roles = [
        'index' => ['?', '@'],
    ];

    public function init()
    {
        parent::init();
        // $this->setPageTitle('Contact Us');
        $this->setBodyClass('contact-us orange');
        $this->setBodyId('contact-us');
    }

}
