<?php

namespace app\modules\Codnitive\Account\controllers;

// use Yii;
// use yii\web\Controller;
use app\modules\Codnitive\Core\filters\AccessControl;
use yii\filters\VerbFilter;
use dektrium\user\controllers\SecurityController as DektriumSecurityController;

class SecurityController extends DektriumSecurityController
{
    use \app\modules\Codnitive\Template\traits\PageControllerTrait;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['login', 'auth'], 'roles' => ['?']],
                    ['allow' => true, 'actions' => ['login', 'auth', 'logout'], 'roles' => ['@']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => [/*'post', */'get'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->layout = '@app/modules/Codnitive/Template/views/layouts/main';
        $this->_request = tools()->stripEscapeRequest(app()->getRequest());
        $this->setBodyClass('account sign-in orange');
        return parent::beforeAction($action);
    }
}
