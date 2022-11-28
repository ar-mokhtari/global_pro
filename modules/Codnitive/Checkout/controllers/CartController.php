<?php

namespace app\modules\Codnitive\Checkout\controllers;

use app\modules\Codnitive\Template\controllers\PageController;
// use yii\filters\VerbFilter;
// use app\modules\Codnitive\Core\filters\AccessControl;

class CartController extends PageController
{
    protected $_baseActionsPath = 'app\modules\Codnitive\Checkout\actions';
    protected $_actions = [
        'index' => ['get'],
    ];
    protected $_roles = [
        'index' => ['?', '@'],
    ];

    // protected $_actionNames = [
    //     'index', 'add', 'remove', 'clear', 'update', 'submitOrder', 'success'
    // ];

    public function init()
    {
        parent::init();
        $this->addBodyClass('checkout-cart');
    }

    /** @inheritdoc */
    // public function behaviors()
    // {
    //     $rules = [];
    //     foreach ($this->_actionNames as $name) {
    //         $rules[] = ['actions' => [$name], 'allow' => true];
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
    //                 'add'         => ['get'],
    //                 'remove'      => ['get'],
    //                 'update'      => ['post'],
    //                 'submitOrder' => ['post'],
    //             ],
    //         ],
    //     ];
    // }

    // public function actions()
    // {
    //     $actions = [];
    //     foreach ($this->_actionNames as $name) {
    //         $actions[$name] = 'app\modules\Codnitive\Checkout\actions\\'.ucfirst($name).'Action';
    //     }
    //     return $actions;
    // }
}
