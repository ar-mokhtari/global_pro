<?php


namespace app\modules\Codnitive\OfficeAutomation\controllers;

use yii\filters\VerbFilter;
use app\modules\Codnitive\Core\filters\AccessControl;
use app\modules\Codnitive\Core\filters\AccessRule;
use app\modules\Codnitive\Admin\controllers\PageController;

class UsersController extends PageController
{
    protected $_baseActionsPath = 'app\modules\Codnitive\OfficeAutomation\actions\users';
    protected $_actions = [
        'index' => ['post'],
    ];
    protected $_roles = [
        'index' => ['admin'],
    ];

    /** @inheritdoc */
    public function behaviors()
    {
        $rules = [];
        $names = [];
        foreach ($this->_actions as $name => $type) {
            $rules[] = ['actions' => [$name], 'allow' => true, 'roles' => ['admin']];
            $names[] = $name;
        }

        return [
            'access' => [
                'class' => AccessControl::className(),
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
            $actions[$name] = 'app\modules\Codnitive\OfficeAutomation\actions\users\\'.ucfirst($name).'Action';
        }
        return $actions;
    }
}