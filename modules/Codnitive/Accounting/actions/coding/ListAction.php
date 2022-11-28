<?php

namespace app\modules\Codnitive\Accounting\actions\coding;


use app\modules\Codnitive\Accounting\actions\MainAction;
use app\modules\Codnitive\CentralOffice\models\coding\CodingSearch;

class ListAction extends MainAction
{
    function run()
    {
        parent::run();
        $searchModel = new CodingSearch() ;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->controller->renderAjax('list.phtml',
            [
                'userIdentity' => tools()->getUser()->identity,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }
}
