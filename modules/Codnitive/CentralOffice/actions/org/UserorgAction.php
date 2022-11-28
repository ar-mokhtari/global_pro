<?php

namespace app\modules\Codnitive\CentralOffice\actions\org;

use app\modules\Codnitive\CentralOffice\actions\MainAction;
use app\modules\Codnitive\CentralOffice\models\coding\VwCodingSearch;
use Yii;

class UserorgAction extends MainAction
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
        $searchModel = new VwCodingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->controller->renderAjax(
            'organization.phtml',
            [
                'userIdentity' => tools()->getUser()->identity,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

}