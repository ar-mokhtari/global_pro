<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\reports;
use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\OutReferrallettersSearch;

/**
 * LettersController implements the CRUD actions for Letters model.
 */
class OutreferrallettersAction extends MainAction
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
        $searchModel = new OutReferrallettersSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->controller->renderAjax('../outreferralletters/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}