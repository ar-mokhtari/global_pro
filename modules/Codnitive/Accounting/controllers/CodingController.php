<?php


namespace app\modules\Codnitive\Accounting\controllers;

use app\modules\Codnitive\Admin\controllers\PageController;
use app\modules\Codnitive\Core\filters\AccessControl;
use app\modules\Codnitive\Core\filters\AccessRule;
use yii\filters\VerbFilter;

class CodingController extends PageController
{
    protected $_baseActionsPath = 'app\modules\Codnitive\Accounting\actions\coding';
    protected $_actions = [
        'list' => ['get', 'post'],
    ];
    protected $_roles = [
        'list' => ['admin'],
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
            $actions[$name] = 'app\modules\Codnitive\Accounting\actions\coding\\'.ucfirst($name).'Action';
        }
        return $actions;
    }
}