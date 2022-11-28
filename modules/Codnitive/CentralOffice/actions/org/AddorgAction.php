<?php

namespace app\modules\Codnitive\CentralOffice\actions\org;

use app\modules\Codnitive\CentralOffice\actions\MainAction;
use app\modules\Codnitive\centralOffice\models\coding\Coding;
use app\modules\Codnitive\CentralOffice\models\coding\VwCodingSearch;
use Yii;

class AddorgAction extends MainAction
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
        $model = new Coding();
        if ($model->load($this->_getRequestPost())) {
            $model->grp = 2;
            $model->level = 2;
            $model->user_create = tools()->getUser()->identity->id;
            $model->save();
        } else {
            if ($this->_getRequestPost('id') <> null) {
                $JID = $this->_getRequestPost('id');
                $FindJob = Coding::findOne(['id' => $JID]);
            } else {
                $FindJob = new Coding();
                $FindJob->id = 0;
                $FindJob->active = 0;
            }
            return $this->controller->renderAjax('addorg.phtml', [
                'model' => $model,
                'FindJob' => $FindJob
            ]);
        }
    }

}