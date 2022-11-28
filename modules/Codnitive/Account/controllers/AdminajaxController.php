<?php

namespace app\modules\Codnitive\Account\controllers;

// use yii\web\Controller;
// use yii\filters\VerbFilter;
// use app\modules\Codnitive\Core\filters\AccessControl;
use app\modules\Codnitive\Admin\controllers\PageController;

class AdminajaxController extends PageController
{
    protected $_baseActionsPath = 'app\modules\Codnitive\Account\actions\Admin\Ajax';
    protected $_actions = [
        'findUser' => ['get'],
    ];
    protected $_roles = [
        'findUser' => ['admin'],
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
    //         $rules[] = ['actions' => [$name], 'allow' => true, 'roles' => $this->_roles[$name]];
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
    //         $actions[$name] = 'app\modules\Codnitive\Account\actions\Admin\Ajax\\'.ucfirst($name).'Action';
    //     }
    //     return $actions;
    // }

}
