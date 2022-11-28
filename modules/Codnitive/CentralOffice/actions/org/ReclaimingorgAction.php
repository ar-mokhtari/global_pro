<?php

namespace app\modules\Codnitive\CentralOffice\actions\org;

use app\modules\Codnitive\CentralOffice\actions\MainAction;
use app\modules\Codnitive\CentralOffice\models\coding\VwCodingSearch;
use Yii;

class ReclaimingorgAction extends MainAction
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
        return 121;
    }

}