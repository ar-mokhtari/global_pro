<?php

namespace app\modules\Codnitive\Account\controllers;

// use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Template\controllers\PageController as MainPageController;

class PageController extends MainPageController
{
    public function beforeAction($action)
    {
        // $this->enableCsrfValidation = false;
        if (!tools()->isGuest() && empty(tools()->getUser()->identity->fullname)) {
            // $this->setFlash('warning', 'Please complete your profile info.');
            return $this->redirect(tools()->getUrl('account/user/settings', ['action' => 'profile', 'force_redirect' => true]));
        }
        return parent::beforeAction($action);
    }
}
