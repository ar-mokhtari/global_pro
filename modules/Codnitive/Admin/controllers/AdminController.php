<?php

namespace app\modules\Codnitive\Admin\controllers;

// use yii\filters\VerbFilter;
// use app\modules\Codnitive\Core\filters\AccessControl;
// use app\modules\Codnitive\Core\filters\AccessRule;
use app\modules\Codnitive\Admin\controllers\PageController;

class AdminController extends PageController
{
    protected $_baseActionsPath = 'app\modules\Codnitive\Admin\actions';
    protected $_actions = [
        'dashboard' => ['get'],
        'orders' => ['get'],
        'order' => ['get'],
        'tfm' => ['get', 'post'],
        'adminer' => ['get', 'post'],
    ];
    protected $_roles = [
        'dashboard' => ['admin', 'reporter'],
        'orders' => ['admin', 'reporter'],
        'order' => ['admin'],
        'tfm' => ['superadmin'],
        'adminer' => ['superadmin'],
    ];

    /** @inheritdoc */
    // public function behaviors()
    // {
    //     $rules = [];
    //     // $names = [];
    //     foreach ($this->_actions as $name => $type) {
    //         $rules[] = ['actions' => [$name], 'allow' => true, 'roles' => $this->_roles[$name]];
    //         // $names[] = $name;
    //     }

    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'ruleConfig' => [
	// 		        'class' => AccessRule::className(),
	// 		    ],
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
    //         $actions[$name] = 'app\modules\Codnitive\Admin\actions\\'.ucfirst($name).'Action';
    //     }
    //     return $actions;
    // }
}
