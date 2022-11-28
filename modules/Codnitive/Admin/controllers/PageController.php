<?php

namespace app\modules\Codnitive\Admin\controllers;

use app\modules\Codnitive\Template\controllers\PageController as MainPageController;

class PageController extends MainPageController
{
    public function beforeAction($action)
    {
        // app()->params['is_admin_panel'] = true;
        app()->getModule('admin');
        // if (!tools()->getUser()->identity->isAdmin) {
        //     throw new ForbiddenHttpException(__('admin', 'You don\'t have permission.'));
        // }
        return parent::beforeAction($action);
    }


    // public function afterAction($action,$params)
    // {
    // }
}
