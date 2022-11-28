<?php

namespace app\modules\Codnitive\Admin\controllers;

// use yii\web\Controller;
// use yii\filters\VerbFilter;
// use app\modules\Codnitive\Core\filters\AccessControl;
use app\modules\Codnitive\Core\controllers\Controller;

class AdminajaxController extends Controller
{
    protected $_baseActionsPath = 'app\modules\Codnitive\Admin\actions\Ajax';
    protected $_actions = [
        'getBalances' => ['get'],
        'getTodayOrders' => ['get'],
        'getPastDaysSales' => ['get'],
    ];
    protected $_roles = [
        'getBalances' => ['superadmin', 'admin', 'reporter'],
        'getTodayOrders' => ['superadmin', 'admin', 'reporter'],
        'getPastDaysSales' => ['superadmin', 'admin', 'reporter'],
    ];

    // public function init()
    // {
    //     // parent::init();
    //     // app()->getModule('admin');
    // }

    // public function run($route, $params = [])
    // {
    //     $route = $route;
    // }

    /** @inheritdoc */
    // public function behaviors()
    // {
    //     $rules = [];
    //     $names = [];
    //     foreach ($this->_actions as $name => $type) {
    //         $rules[] = ['actions' => [$name], 'allow' => true, 'roles' => ['admin']];
    //         $names[] = $name;
    //     }

    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'only'  => $names,
    //             'rules' => $rules,
    //         ],
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => $this->_actions,
    //         ],
    //     ];
    // }

    // public function actions()
    // {
    //     $actions = [];
    //     foreach ($this->_actions as $name => $type) {
    //         $actions[$name] = 'app\modules\Codnitive\Admin\actions\Ajax\\'.ucfirst($name).'Action';
    //     }
    //     return $actions;
    // }

}
