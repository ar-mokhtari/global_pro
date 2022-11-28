<?php

namespace app\modules\Codnitive\Account\controllers;

// use Yii;
// use yii\helpers\Json;
// use yii\web\Controller;
use dektrium\user\controllers\SettingsController as DektriumSettingsController;

class SettingsController extends DektriumSettingsController
{
    use \app\modules\Codnitive\Template\traits\PageControllerTrait;

    public function beforeAction($action)
    {
        $this->_request = tools()->stripEscapeRequest(app()->getRequest());
        if ($this->_request->get('force_redirect')) {
            app()->getSession()->setFlash('success', __('account', 'Please complete your profile info.'));
        }
        $this->setBodyClass('account settings profile orange');
        $this->layout = '@app/modules/Codnitive/Account/views/layouts/main';
        // $this->view->params['active_menu'] = Json::encode(['profile']);
        $this->view->params['active_menu'] = 'profile';
        return parent::beforeAction($action);
    }
}
