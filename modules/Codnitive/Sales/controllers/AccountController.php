<?php

namespace app\modules\Codnitive\Sales\controllers;

// use yii\filters\VerbFilter;
// use app\modules\Codnitive\Core\filters\AccessControl;
use app\modules\Codnitive\Account\controllers\PageController;

class AccountController extends PageController
{
    protected $_baseActionsPath = 'app\modules\Codnitive\Sales\actions\Account';
    protected $_actions = [
        'list' => ['get'], 
        'order' => ['get'], 
        'received' => ['get'], 
        'getOrderDetails' => ['post'], 
        'refund' => ['get']
    ];
    protected $_roles = [
        'list' => ['@'],
        'order' => ['@'],
        'received' => ['@'],
        'getOrderDetails' => ['@'],
        'refund' => ['@'],
    ];

    public function init()
    {
        parent::init();
        $this->setBodyClass('account sales orders orange');
    }

    // public function beforeAction($action)
    // {
    //     // $this->_order = new \app\modules\Codnitive\Sales\models\Order;
    //     $this->setBodyClass('account sales orders orange');
    //     return parent::beforeAction($action);
    // }

    // public function getEventModel($id = null)
    // {
    //     if (empty($this->_event)) {
    //         $this->_event = new \app\modules\Codnitive\Event\models\Event();
    //     }
    //     return $id ? $this->_event->loadOne($id) : $this->_event;
    // }

    /** @inheritdoc */
    // public function behaviors()
    // {
    //     $rules = [];
    //     foreach ($this->_actionNames as $name) {
    //         $rules[] = ['actions' => [$name], 'allow' => true, 'roles' => ['@']];
    //     }

    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'only' => $this->_actionNames,
    //             'rules' => $rules,
    //         ],
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 // 'index' => ['post'],
    //                 'getOrderDetails' => ['post'],
    //             ],
    //         ],
    //     ];
    // }

    // public function actions()
    // {
    //     $actions = [];
    //     foreach ($this->_actionNames as $name) {
    //         $actions[$name] = 'app\modules\Codnitive\Sales\actions\Account\\'.ucfirst($name).'Action';
    //     }
    //     return $actions;
    // }
}
