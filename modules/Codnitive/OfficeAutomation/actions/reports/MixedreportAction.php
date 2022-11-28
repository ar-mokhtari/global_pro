<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\reports;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\VwLettersSearch;
use Yii;


/**
 * LettersController implements the CRUD actions for Letters model.
 */
class MixedreportAction extends MainAction
{

    /**
     *  * inline tags demonstration
     *
     * this function ask from Category and Content model to prepare data, then post them to view
     * @return string|void
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function run()
    {
        parent::run();
        $searchModel = new VwLettersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'ALL');

        return $this->controller->renderAjax('../mixedreport/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}