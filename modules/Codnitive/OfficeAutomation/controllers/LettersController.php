<?php


namespace app\modules\Codnitive\OfficeAutomation\controllers;

use yii\filters\VerbFilter;
use app\modules\Codnitive\Core\filters\AccessControl;
use app\modules\Codnitive\Core\filters\AccessRule;
use app\modules\Codnitive\Admin\controllers\PageController;

class LettersController extends PageController
{
    protected $_baseActionsPath = 'app\modules\Codnitive\OfficeAutomation\actions\letters';
    protected $_actions = [
        'lunchmodal' => ['post'],
        'draft' => ['get','post'],
        'checkresponse' => ['post'],
        'updating' => ['get','post'],
        'deleting' => ['post'],
        'senddraft' => ['post'],
        'sendforusers' => ['post'],
        'addattachfile' => ['post'],
        'delattachfile' => ['post'],
        'downloadattach' => ['get'],
        'sendanswer' => ['post'],
        'showletter' => ['post'],
        'answerletters' => ['post'],
        'delletter' => ['post'],
        'referralletters' => ['post'],
        'sendreferral' => ['post'],
    ];
    protected $_roles = [
        'lunchmodal' => ['admin'],
        'draft' => ['admin'],
        'checkresponse' => ['admin'],
        'updating' => ['admin'],
        'deleting' => ['admin'],
        'senddraft' => ['admin'],
        'sendforusers' => ['admin'],
        'addattachfile' => ['admin'],
        'delattachfile' => ['admin'],
        'downloadattach' => ['admin'],
        'sendanswer' => ['admin'],
        'showletter' => ['admin'],
        'answerletters' => ['admin'],
        'delletter' => ['admin'],
        'referralletters' => ['admin'],
        'sendreferral' => ['admin'],
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
            $actions[$name] = 'app\modules\Codnitive\OfficeAutomation\actions\letters\\'.ucfirst($name).'Action';
        }
        return $actions;
    }
}