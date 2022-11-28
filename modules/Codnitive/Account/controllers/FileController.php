<?php

namespace app\modules\Codnitive\Account\controllers;

use yii\filters\VerbFilter;
use app\modules\Codnitive\Core\filters\AccessControl;
// use app\modules\Codnitive\Core\filters\AccessRule;
// use app\modules\Codnitive\Account\actions\Index;
use app\modules\Codnitive\Account\controllers\PageController;

class FileController extends PageController
{
    /*public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }*/

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['deleteImage'],
                'rules' => [
                    ['actions' => ['deleteImage'], 'allow' => true, 'roles' => ['@']],
                    // ['actions' => ['delete'], 'allow' => false, 'roles' => ['*']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'deleteImage' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            // 'delete' => 'app\modules\Codnitive\Account\actions\File\DeleteAction',
            'deleteImage' => 'app\modules\Codnitive\Account\actions\File\DeleteImageAction',
            // 'deleteFile' => 'app\modules\Codnitive\Account\actions\File\DeleteImageAction',
        ];
    }
}
