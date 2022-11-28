<?php

namespace app\modules\Codnitive\Account\controllers;

// use Yii;
// use yii\web\Controller;
use dektrium\user\controllers\ProfileController as DektriumProfileController;

class ProfileController extends DektriumProfileController
{
    use \app\modules\Codnitive\Template\traits\PageControllerTrait;

    public function beforeAction($action)
    {
        $this->setBodyClass('account orange');
        $this->layout = '@app/modules/Codnitive/Account/views/layouts/main';
        $this->_request = tools()->stripEscapeRequest(app()->getRequest());
        return parent::beforeAction($action);
    }
}
