<?php

namespace app\modules\Codnitive\Accounting\actions\docs;

use app\modules\codnitive\accounting\actions\MainAction;
use app\modules\codnitive\accounting\models\Acc_documentsSearch;
use app\modules\Codnitive\Accounting\models\AccDocs;
use yii\data\Pagination;


class Docs_formAction extends MainAction
{
    function run()
    {
        parent::run();
        //-----------Master-----------------
        // build a DB query to get all docs with Status = 1
        $query = AccDocs::find()->where(['Status' => 1]);
        // get the total number of docs (but do not fetch the doc data yet)
        $count = $query->count();
        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 1]);
        // limit the query using the pagination and retrieve the docs
        $AccDocs = $query->offset($pagination->getOffset())
            ->limit($pagination->getLimit())
            ->all();
        $dateParts = explode(' ', tools()->getFormattedDate($AccDocs[0]->DocDate, 'Y-m-d H:i'));
        $AccDocs[0]->DocDate = str_replace('-', '/', (new \app\modules\Codnitive\Calendar\models\Persian())->getDate($dateParts[0]));
        //-----------Master-----------------
        //-----------Details:-----------------//
        $searchModel_Details = new Acc_documentsSearch();
        $doc_id = $this->_retriveRequest()->_getRequestGet('page') == null ? 1 : $this->_retriveRequest()->_getRequestGet('page');
        $dataProvider_Details = $searchModel_Details->search(\Yii::$app->request->queryParams, $doc_id);
        //-----------Details:-----------------//

        return $this->controller->renderAjax('_form.php',
            [
                'userIdentity' => tools()->getUser()->identity,
                'model' => $AccDocs[0],
                'pagination' => $pagination,
                'searchModel_Details' => $searchModel_Details,
                'dataProvider_Details' => $dataProvider_Details,
            ]
        );
    }
}
