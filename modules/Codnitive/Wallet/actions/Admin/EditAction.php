<?php

namespace app\modules\Codnitive\Wallet\actions\Admin;

use app\modules\Codnitive\Admin\actions\MainAction;

class EditAction extends MainAction
{
    /**
     * Disbale CSRF validation
     */
    // public function init()
    // {
    //     parent::init();
    //     app()->controller->enableCsrfValidation = false;    
    // }
    
    public function run()
    {
        parent::run();
        $this->controller->view->title = __('admin', 'Wallet');
        $this->controller->setBodyClass($this->controller->getBodyClass() . ' dashboard admin wallet edit');

        $this->controller->view->params['breadcrumbs'][10] = __('admin', 'Wallet');
        $this->controller->view->params['active_menu'] = 'wallet';

        return $this->controller->render('@app/modules/Codnitive/Admin/views/layouts/edit/form.phtml', [
            'block' => new \app\modules\Codnitive\Wallet\blocks\Admin\Edit(
                new \app\modules\Codnitive\Wallet\models\Admin\EditForm
            ),
        ]);
    }
}
