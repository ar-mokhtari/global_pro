<?php

namespace app\modules\Codnitive\CentralOffice\actions\org;

use app\modules\Codnitive\CentralOffice\actions\MainAction;
use app\modules\Codnitive\CentralOffice\models\coding\Coding;
use app\modules\Codnitive\CentralOffice\models\coding\Codingrelation;
use app\modules\Codnitive\CentralOffice\models\coding\VwCoding;
use app\modules\Codnitive\CentralOffice\blocks\AddForm;
use Yii;

class DelorgrelationAction extends MainAction
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
        $id = $this->_getRequestPost('id');
        $all_codes = $this->_getRequestPost('all');
        if (isset($all_codes)) {
            \Yii::$app
                ->db
                ->createCommand()
                ->delete('coding_relation', ['id' => $all_codes])
                ->execute();
        } else {
            $model = Codingrelation::findOne(['id' => $id]);
            $model->delete();
        }
    }
}