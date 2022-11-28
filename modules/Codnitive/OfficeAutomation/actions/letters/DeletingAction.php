<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\Letters;
use Yii;

class DeletingAction extends MainAction
{
    function run()
    {
        parent::run();
        $lettersID = $this->_getRequestPost('id');
        $model = Letters::findOne(['LettersID' => $lettersID]);
        switch ($model->LettersAttachmentType) {
            case 0:
                $model->delete();
                break;
            case 1:
                $file = Yii::getAlias('@webroot') . '/office/upload/' . $model->LettersAttachmentUrl;
                if (file_exists($file)) {
                    unlink($file);
                    $model->delete();
                } else {
                    $model->delete();
                }
                break;
            default:
                break;
        }
    }
}
