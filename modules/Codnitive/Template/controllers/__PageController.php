<?php

namespace app\modules\Codnitive\Template\controllers;

// use Yii;
// use yii\web\Controller;
// use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Core\controllers\Controller;

class PageController extends Controller
{
    use \app\modules\Codnitive\Template\traits\PageControllerTrait;

    public function beforeAction($action)
    {
        $this->_request = tools()->stripEscapeRequest(app()->getRequest());
        app()->language = tools()->getLanguage();
        $layout = 'main';
        if ('1' === $this->_request->get('blank')) {
            $layout = 'blank';
            $this->addBodyClass('blank');
        }
        $this->layout   = "@app/modules/Codnitive/Template/views/layouts/$layout";
        // $this->view->defaultExtension = app()->getModule('template')->params['defaultExtension'];
        unset($this->view->params['active_menu']);
        return parent::beforeAction($action);
    }
}
