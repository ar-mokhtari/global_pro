<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\reports;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\InReferrallettersSearch;

/**
 * LettersController implements the CRUD actions for Letters model.
 */
class InreferrallettersAction extends MainAction
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
        $searchModel = new InReferrallettersSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->controller->renderAjax('../inreferralletters/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}