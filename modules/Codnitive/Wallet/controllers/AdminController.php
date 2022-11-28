<?php

namespace app\modules\Codnitive\Wallet\controllers;

use yii\filters\VerbFilter;
use app\modules\Codnitive\Core\filters\AccessControl;
use app\modules\Codnitive\Core\filters\AccessRule;
use app\modules\Codnitive\Admin\controllers\PageController;

class AdminController extends PageController
{
    protected $_baseActionsPath = 'app\modules\Codnitive\Wallet\actions\Admin';
    protected $_actions = [
        'edit' => ['get'],
        'save' => ['post'],
    ];
    protected $_roles = [
        'edit' => ['admin'],
        'save' => ['admin'],
    ];

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
    //         $actions[$name] = 'app\modules\Codnitive\Wallet\actions\Admin\\'.ucfirst($name).'Action';
    //     }
    //     return $actions;
    // }
}
