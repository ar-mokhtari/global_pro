<?php

namespace app\modules\Codnitive\Cms\controllers;

use app\modules\Codnitive\Template\controllers\PageController;

class TermsController extends PageController
{
    protected $_baseActionsPath = 'app\modules\Codnitive\Cms\actions\Terms';
    protected $_actions = [
        'index' => ['get'],
        // 'bus' => ['get'],
        // 'insurance' => ['get'],
    ];
    protected $_roles = [
        'index' => ['?', '@'],
    ];

    public function init()
    {
        parent::init();
        // $this->setPageTitle('Contact Us');
        $this->setBodyClass('terms orange');
        $this->setBodyId('terms');
    }
}
