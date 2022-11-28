<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\users;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\UsersSearch;
use dektrium\user\models\User;


/**
 * LettersController implements the CRUD actions for Letters model.
 */
class IndexAction extends MainAction
{

    /**
     *  * inline tags demonstration
     *
     * this function ask from Category and Content model to prepare data, then post them to view
     * @return string|void
     */
    public function run()
    {
        parent::run();
        $model = new User();
        if ($model->load(\Yii::$app->request->post())) {
            if ($model->save()) {

            };
        }
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->controller->renderAjax('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

}