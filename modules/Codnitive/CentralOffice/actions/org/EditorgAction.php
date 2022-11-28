<?php

namespace app\modules\Codnitive\CentralOffice\actions\org;

use app\modules\Codnitive\CentralOffice\actions\MainAction;
use app\modules\Codnitive\CentralOffice\models\coding\Coding;
use app\modules\Codnitive\CentralOffice\models\coding\VwCoding;
use app\modules\Codnitive\CentralOffice\blocks\AddForm;
use Yii;

class EditorgAction extends MainAction
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
        if ($JID != null) {
            app()->session->set('JobsID', $JID);
        }
        $OrgID = app()->session->get('JobsID');
        $model = VwCoding::findOne(['id' => $OrgID]);
        if ($model->load(Yii::$app->request->post())) {
            $UpdatingJobs = Coding::findOne(['id' => $OrgID]);
            $UpdatingJobs->name = $model->name;
            $UpdatingJobs->parent = $this->_getRequestPost('parent');
            $UpdatingJobs->update();
        } else {
            $org_codes = Coding::find()
                ->select(['id', 'name'])
                ->where(['grp' => 2])
                ->andWhere(['NOT IN', 'id', $OrgID])
                ->all();
            $all_org = [];
            foreach ($org_codes as $value) {
                $all_org[$value->id] = $value->name;
            }
            $block = (new AddForm());
            return $this->controller->renderAjax('editorg.phtml', [
                'model' => $model,
                'all_org' => $all_org,
                'block' => $block,
            ]);
        }
    }
}