<?php

namespace app\modules\Codnitive\Admin\actions;

use app\modules\Codnitive\Admin\actions\MainAction;

class AdminerAction extends MainAction
{
    /**
     * Disbale CSRF validation for loading search form
     */
    public function init()
    {
        parent::init();
        app()->controller->enableCsrfValidation = false;    
    }
    
    public function run()
    {
        require app()->basePath . '/modules/Codnitive/Admin/models/Adminer.php';
        exit;
    }
}
