<?php

namespace app\modules\Codnitive\Checkout\actions\VirtualCart\Ajax;

use app\modules\Codnitive\Checkout\actions\VirtualCart\ActionAbstract;

abstract class AjaxAbstract extends ActionAbstract
{
    /**
     * Disbale CSRF validation for loading search form
     */
    public function init()
    {
        parent::init();
        app()->getModule($this->_moduleId);
        // app()->controller->enableCsrfValidation = false;
    }
}
