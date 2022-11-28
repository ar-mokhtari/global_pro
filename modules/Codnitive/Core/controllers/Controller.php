<?php

namespace app\modules\Codnitive\Core\controllers;

use yii\web\Controller as BaseController;
use yii\filters\VerbFilter;
use app\modules\Codnitive\Core\filters\AccessControl;
use app\modules\Codnitive\Core\filters\AccessRule;

abstract class Controller extends BaseController
{
    protected $_baseActionsPath = '';
    protected $_actions = [];

    /**
     * @link https://www.yiiframework.com/doc/guide/2.0/en/security-authorization
     * 
     * ?: matches a guest user (not authenticated yet)
     * @: matches an authenticated user
     */
    protected $_roles = [];

    /** @inheritdoc */
    public function behaviors()
    {
        $rules = [];
        $names = [];
        foreach ($this->_actions as $name => $type) {
            $rules[] = ['actions' => [$name], 'allow' => true, 'roles' => $this->_roles[$name]];
            $names[] = $name;
        }

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => $names,
                'ruleConfig' => [
			        'class' => AccessRule::className(),
			    ],
                'rules' => $rules,
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => $this->_actions,
            ],
        ];
    }

    public function actions()
    {
        $actions = [];
        foreach ($this->_actions as $name => $type) {
            $actions[$name] = $this->_baseActionsPath.'\\'.\ucfirst($name).'Action';
        }
        return $actions;
    }

    public function beforeAction($action)
    {
        // app()->params['is_admin_panel'] = true;
        app()->getModule('admin');
        // if (!tools()->getUser()->identity->isAdmin) {
        //     throw new ForbiddenHttpException(__('admin', 'You don\'t have permission.'));
        // }
        return parent::beforeAction($action);
    }


    // public function afterAction($action,$params)
    // {
    // }
}
