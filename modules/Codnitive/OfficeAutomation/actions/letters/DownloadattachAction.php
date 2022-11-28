<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\Letters;
use Yii;

class DownloadattachAction extends MainAction
{
    function run()
    {
        parent::run();
        $findLetters = Letters::findOne(['LettersID' => $this->_getRequestGet('id')]);
        if ($findLetters && $findLetters->LettersAttachmentType == 1) {
            $file = Yii::getAlias('@webroot') . '/office/upload/' . $findLetters->LettersAttachmentUrl;
            if (file_exists($file)) {
                Yii::$app->response->sendFile($file);
            } else {
                throw new NotFoundHttpException('فایل پیدا نشد');
            }
        }
    }
}
