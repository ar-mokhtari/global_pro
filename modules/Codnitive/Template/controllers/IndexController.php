<?php

namespace app\modules\Codnitive\Template\controllers;

// use yii\helpers\Json;
use app\modules\Codnitive\Template\controllers\PageController;
// use app\modules\Codnitive\Core\Module as CoreModule;

class IndexController extends PageController
{
    protected $_baseActionsPath = 'app\modules\Codnitive\Template\actions';
    protected $_actions = [
        'index' => ['get', 'post'],
    ];

    /**
     * @link https://www.yiiframework.com/doc/guide/2.0/en/security-authorization
     * 
     * ?: matches a guest user (not authenticated yet)
     * @: matches an authenticated user
     */
    protected $_roles = [
        'index' => ['?', '@'], 
    ];

    // private $modulesList = [
    //     'insurance',
    //     'bus'
    // ];

    // public function actionIndex()
    // {
    //     // $this->_test();
    //     // CoreModule::loadModules($this->modulesList);
    //     // $this->loadModules();
        
    //     // return $this->render('@app/modules/Codnitive/Template/views/layouts/index/home');
    //     // $this->view->params['customParam'] = 'customValue';
    //     // \Yii::$app->view->params['customParam'] = 'customValue';
    //     $this->setBodyClass('homepage');
    //     $this->setBodyId('homepage');
    //     // $this->view->params['active_menu'] = Json::encode(['home']);
    //     $this->view->params['active_menu'] = 'home';
    //     $this->setHeaderBottom('home/slider.phtml');
    //     return $this->render('home.phtml');
    // }

    // private function loadModules()
    // {
    //     foreach ($this->modulesList as $module) {
    //         app()->getModule($module);
    //     }
    // }

    // private function _test()
    // {
    //     $hotels = new \app\modules\Codnitive\StaticData\models\Hotels;
    //     $hotels->getHotels()
    //     exit;
    // }
}
