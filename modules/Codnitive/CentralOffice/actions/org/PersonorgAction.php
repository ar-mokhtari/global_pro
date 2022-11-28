<?php

namespace app\modules\Codnitive\CentralOffice\actions\org;

use app\modules\Codnitive\CentralOffice\actions\MainAction;
use app\modules\Codnitive\CentralOffice\blocks\AddForm;
use app\modules\Codnitive\CentralOffice\models\coding\Coding;
use app\modules\Codnitive\CentralOffice\models\coding\Codingrelation;
use app\modules\Codnitive\CentralOffice\models\coding\VwCodingrelationSearch;
use Yii;

class PersonorgAction extends MainAction
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
        $JID = $this->_getRequestPost('id');
        ($JID != null) ? app()->session->set('JobsID', $JID) : false;
        $OrgID = app()->session->get('JobsID');
        $code_name = $this->_getRequestPost('name');
        $model = new Codingrelation();
// ---------- Save -------------
        $new_cods = $this->_getRequestPost('second_code');
        if ($new_cods) {
            try {
                foreach ($new_cods as $code) {
                    $new_model = new Codingrelation();
                    $new_model->first_code = $OrgID;
                    $new_model->second_code = $code;
                    $new_model->save();
                }
//                return '<div></div>';
            } catch (\Exception $e) {
//                app()->getSession()->setFlash('warning', __('account', 'Duplicated Info'));
                return '121';
            }
        }
// ---------- Save -------------

// ---------- Prepare Organization none duplicate -------------
        $array = [];
        $relation = Codingrelation::find()
            ->select('second_code')
            ->where(['first_code' => $OrgID])
            ->asArray()
            ->all();
        foreach ($relation as $key => $item) {
            array_push($array, $item['second_code']);
        }
        $org_codes = Coding::find()
            ->select(['id', 'name'])
            ->where(['grp' => 3])
            ->andWhere(['NOT IN', 'id', $array])
            ->all();
        $all_org = [];
        foreach ($org_codes as $value) {
            $all_org[$value->id] = $value->name;
        }
// ---------- Prepare Organization none duplicate -------------
        $block = (new AddForm());
        $searchModel = new VwCodingrelationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->controller->renderAjax('personorg.phtml', [
            'model' => @$model,
            'all_org' => $all_org,
            'block' => $block,
            'code_name' => $code_name,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }
}