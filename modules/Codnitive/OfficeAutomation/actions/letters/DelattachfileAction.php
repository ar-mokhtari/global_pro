<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\Letters;
use Yii;
use yii\helpers\Json;

class DelattachfileAction extends MainAction
{
    function run()
    {
        parent::run();
        $file = '';
        $lettersID = $this->_getRequestPost('id');
        $model = Letters::findOne(['LettersID' => $lettersID]);
        if ($model) {
            if ($model->LettersAttachmentUrl != '' and $model->LettersAttachmentType == 1) {
                $file = Yii::getAlias('@webroot') . '/office/upload/' . $model->LettersAttachmentUrl;
                $model->LettersAttachmentType = 0;
                $model->LettersAttachmentUrl = '';
                $model->LettersAttachmentFileName = '';
                $model->LettersAttachFileExtention = '';
                $model->update();
            }
            if (file_exists($file)) {
                unlink($file);
                return Json::encode(array('resCode' => 100, 'resMsg' => 'فایل حذف شد'));
            } else {
                return Json::encode(array('resCode' => 201, 'resMsg' => 'فایلی جهت حذف پیدا نشد'));
            }
        } else {
            return Json::encode(array('resCode' => 202, 'resMsg' => 'نامه پیدا نشد'));
        }
    }
}
