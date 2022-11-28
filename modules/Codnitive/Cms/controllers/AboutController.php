<?php

namespace app\modules\Codnitive\Cms\controllers;

use app\modules\Codnitive\Template\controllers\PageController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class AboutController extends PageController
{
    protected $_actions = [
        'index' => ['get'],
    ];

    public function init()
    {
        parent::init();
        $this->setBodyClass('about-us orange');
        $this->setBodyId('about-us');
    }

    /** @inheritdoc */
    public function behaviors()
    {
        $rules = [];
        $names = [];
        foreach ($this->_actions as $name => $type) {
            $rules[] = ['actions' => [$name], 'allow' => true];
            $names[] = $name;
        }

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => $names,
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
            $actions[$name] = 'app\modules\Codnitive\Cms\actions\About\\'.ucfirst($name).'Action';
        }
        return $actions;
    }
}
