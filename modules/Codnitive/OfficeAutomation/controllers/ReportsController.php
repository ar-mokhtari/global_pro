<?php


namespace app\modules\Codnitive\OfficeAutomation\controllers;

use yii\filters\VerbFilter;
use app\modules\Codnitive\Core\filters\AccessControl;
use app\modules\Codnitive\Core\filters\AccessRule;
use app\modules\Codnitive\Admin\controllers\PageController;

class ReportsController extends PageController
{
    protected $_baseActionsPath = 'app\modules\Codnitive\OfficeAutomation\actions\reports';
    protected $_actions = [
        'forceletters' => ['post'],
        'inreferralletters' => ['post','get'],
        'letterstrash' => ['post'],
        'outreferralletters' => ['post'],
        'readedletters' => ['post'],
        'recieveletter' => ['get', 'post'],
        'securityletters' => ['post'],
        'sendletters' => ['post'],
        'unreadedletters' => ['post'],
        'showinreferralletters' => ['post'],
        'addreferal' => ['post'],
        'sendreferral' => ['post'],
        'mixedreport' => ['post', 'get'],
        'showletter' => ['post', 'get'],
        'showdescription' => ['post', 'get'],

    ];
    protected $_roles = [
        'forceletters' => ['admin'],
        'inreferralletters' => ['admin'],
        'letterstrash' => ['admin'],
        'outreferralletters' => ['admin'],
        'readedletters' => ['admin'],
        'recieveletter' => ['admin'],
        'securityletters' => ['admin'],
        'unreadedletters' => ['admin'],
        'Showinreferralletters' => ['admin'],
        'addreferal' => ['admin'],
        'sendreferral' => ['admin'],
        'mixedreport' => ['admin'],
        'showletter' => ['admin'],
        'showdescription' => ['admin'],
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
            $actions[$name] = 'app\modules\Codnitive\OfficeAutomation\actions\reports\\'.ucfirst($name).'Action';
        }
        return $actions;
    }
}