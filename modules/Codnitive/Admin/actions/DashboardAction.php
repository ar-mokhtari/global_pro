<?php

namespace app\modules\Codnitive\Admin\actions;

use app\modules\Codnitive\Admin\actions\MainAction;
use app\modules\Codnitive\Admin\models\Orders\Grid\Dashboard as DashboardGrid;
use app\modules\Codnitive\Admin\blocks\Dashboard;

class DashboardAction extends MainAction
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
        app()->getModule(\app\modules\Codnitive\Reports\Module::MODULE_ID);
        app()->getModule(\app\modules\Codnitive\Sales\Module::MODULE_ID);
        $this->controller->view->title = __('admin', 'Admin Panel Dashboard');
        $this->controller->setBodyClass($this->controller->getBodyClass() . ' dashboard');

        return $this->controller->render('/templates/dashboard.phtml', [
            'block' => new Dashboard,
            'ordersGrid' => (new DashboardGrid)->setLimit(10)
        ]);
    }
}
