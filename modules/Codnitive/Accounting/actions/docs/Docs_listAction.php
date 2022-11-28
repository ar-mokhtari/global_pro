<?php

namespace app\modules\Codnitive\Accounting\actions\docs;



use app\modules\codnitive\accounting\actions\MainAction;
use app\modules\codnitive\accounting\models\AccdocsSearch;

class Docs_listAction extends MainAction
{
    function run()
    {
        parent::run();
        $searchModel = new AccdocsSearch() ;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->controller->renderAjax('index.php',
            [
                'userIdentity' => tools()->getUser()->identity,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }
}
