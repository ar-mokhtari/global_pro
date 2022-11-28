<?php

namespace app\modules\Codnitive\CentralOffice\actions\org;

use app\modules\Codnitive\CentralOffice\actions\MainAction;
use app\modules\Codnitive\CentralOffice\models\coding\Coding;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class DelorgAction extends MainAction
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
        $delLetterTransaction = Coding::getDb()->beginTransaction();
        try {
            $del_id = $this->_getRequestPost('id');
            $model = Coding::findOne(['id' => $del_id]);
            if ($model->delete()) {
                $delLetterTransaction->commit();
                return Json::encode(['resMsg' => 'واحد سازمانی با موفقیت حذف شد']);
            }
            $model->delete();
        } catch (\Exception $error) {
            $delLetterTransaction->rollBack();
            throw new NotFoundHttpException('خـطا: DelCoding/Org');
        } catch (\Throwable $e) {
        }

    }

}