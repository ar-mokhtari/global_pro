<?php

namespace app\modules\Codnitive\Wallet\controllers;

use yii\filters\VerbFilter;
use app\modules\Codnitive\Core\filters\AccessControl;
use app\modules\Codnitive\Account\controllers\PageController;

class AccountController extends PageController
{
    protected $_baseActionsPath = 'app\modules\Codnitive\Wallet\actions\Account';
    protected $_actions = [
        'index' => ['get'],
        'chargeRequest' => ['post'],
        'charge' => ['post'],
    ];
    protected $_roles = [
        'index' => ['@'],
        'chargeRequest' => ['@'],
        'charge' => ['@'],
    ];

    public function init()
    {
        parent::init();
        $this->setBodyClass('account wallet orange');
        $this->setBodyId('wallet-account');
    }

    /** @inheritdoc */
    // public function behaviors()
    // {
    //     $rules = [];
    //     $names = [];
    //     foreach ($this->_actions as $name => $type) {
    //         $rules[] = ['actions' => [$name], 'allow' => true, 'roles' => ['@']];
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
    //         $actions[$name] = 'app\modules\Codnitive\Wallet\actions\Account\\'.ucfirst($name).'Action';
    //     }
    //     return $actions;
    // }
}
