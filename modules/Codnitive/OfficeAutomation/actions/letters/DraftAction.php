<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\OfficeAutomation\models\VwLettersSearch;
use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\CentralOffice\blocks\AddForm;

use Yii;

/**
 * LettersController implements the CRUD actions for Letters model.
 */
class DraftAction extends MainAction
{

    /**
     *  * inline tags demonstration
     *
     * this function ask from Category and Content model to prepare data, then post them to view
     * @return string|void
     * @throws \yii\web\NotFoundHttpException
     */
    public function run()
    {
        parent::run();
        $searchModel = new VwLettersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $block = (new AddForm());
        return $this->controller->renderAjax(
            'index.php',
            [
                'userIdentity' => tools()->getUser()->identity,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'block' => $block,
            ]
        );
    }

}