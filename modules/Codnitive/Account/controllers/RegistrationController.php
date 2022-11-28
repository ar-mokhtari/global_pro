<?php

namespace app\modules\Codnitive\Account\controllers;

// use Yii;
// use yii\web\Controller;
use dektrium\user\controllers\RegistrationController as DektriumRegistrationController;

class RegistrationController extends DektriumRegistrationController
{
    use \app\modules\Codnitive\Template\traits\PageControllerTrait;

    public function beforeAction($action)
    {
        $this->layout = '@app/modules/Codnitive/Template/views/layouts/main';
        $this->_request = tools()->stripEscapeRequest(app()->getRequest());
        $this->setBodyClass('account sign-up orange');
        return parent::beforeAction($action);
    }

}
