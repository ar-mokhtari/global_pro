<?php


namespace app\modules\Codnitive\CentralOffice\controllers;

use yii\filters\VerbFilter;
use app\modules\Codnitive\Core\filters\AccessControl;
use app\modules\Codnitive\Core\filters\AccessRule;
use app\modules\Codnitive\Admin\controllers\PageController;

class OrgController extends PageController
{
    protected $_baseActionsPath = 'app\modules\Codnitive\CentralOffice\actions\org';
    protected $_actions = [
        'index' => ['get', 'post'],
        'addorg' => ['get', 'post'],
        'editorg' => ['get', 'post'],
        'personorg' => ['get', 'post'],
        'delorg' => ['get', 'post'],
        'delorgrelation' => ['get', 'post'],
    ];
    protected $_roles = [
        'index' => ['admin'],
        'addorg' => ['admin'],
        'editorg' => ['admin'],
        'personorg' => ['admin'],
        'delorg' => ['admin'],
        'delorgrelation' => ['admin'],
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
            $actions[$name] = 'app\modules\Codnitive\CentralOffice\actions\org\\' . ucfirst($name) . 'Action';
        }
        return $actions;
    }
}