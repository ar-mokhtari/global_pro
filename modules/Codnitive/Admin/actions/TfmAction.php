<?php

namespace app\modules\Codnitive\Admin\actions;

use app\modules\Codnitive\Admin\actions\MainAction;

class TfmAction extends MainAction
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
        define('FM_EMBED', true);
        define('FM_SELF_URL', tools()->getUrl('admin/tfm')); // must be set if URL to manager not equal PHP_SELF
        require app()->basePath . '/modules/Codnitive/Core/models/TFileManager.php';
        exit;
    }
}
