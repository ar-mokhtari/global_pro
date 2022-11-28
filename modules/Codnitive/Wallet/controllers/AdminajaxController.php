<?php

namespace app\modules\Codnitive\Wallet\controllers;

// use yii\web\Controller;
// use yii\filters\VerbFilter;
// use app\modules\Codnitive\Core\filters\AccessControl;
// use app\modules\Codnitive\Core\filters\AccessRule;
// use app\modules\Codnitive\Core\filters\AccessControl;
use app\modules\Codnitive\Core\controllers\Controller;

class AdminajaxController extends Controller
{
    protected $_baseActionsPath = 'app\modules\Codnitive\Wallet\actions\Admin\Ajax';
    protected $_actions = [
        'getCredit' => ['post'],
    ];
    protected $_roles = [
        'getCredit' => ['admin'],
    ];

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
    //         $rules[] = ['actions' => [$name], 'allow' => true, 'roles' => ['superadmin']];
    //         $names[] = $name;
    //     }

    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'only'  => $names,
    //             'rules' => $rules,
    //             'ruleConfig' => [
	// 		        'class' => AccessRule::className(),
	// 		    ],
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
    //         $actions[$name] = 'app\modules\Codnitive\Wallet\actions\Admin\Ajax\\'.ucfirst($name).'Action';
    //     }
    //     return $actions;
    // }

}
