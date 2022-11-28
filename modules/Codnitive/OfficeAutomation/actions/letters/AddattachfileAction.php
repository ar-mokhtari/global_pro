<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\LettersForAttach;
use yii\web\UploadedFile;

class AddattachfileAction extends MainAction
{
    function run()
    {
        parent::run();
        $lettersID = $this->_getRequestPost('id');
        $session = app()->session;
        if ($lettersID != null) {
            $session->set('addAttachID', $lettersID);
        }
        $model = LettersForAttach::findOne(['LettersID' => $session->get('addAttachID')]);
        if ($model->LettersAttachmentType == 0) {
            if ($model->load($this->_getRequestPost())) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if (!empty($model->imageFile)) {
                    $model->LettersAttachmentType = 1;//means letter have attachment
                    $fileName = sha1(time() . $model->imageFile->baseName);
                    $model->imageFile->
                    saveAs( 'office/upload/' . $fileName . '.' . $model->imageFile->extension, false);
                    $model->LettersAttachmentUrl = $fileName . '.' . $model->imageFile->extension;
                    $model->LettersAttachmentFileName =
                        $model->imageFile->baseName . '.' . $model->imageFile->extension;
                    $model->LettersAttachFileExtention = $model->imageFile->extension;
                    $model->save();
                    return '<div></div>';
                }
            } else {
                return $this->controller->renderAjax('addAttach', ['model' => $model]);
            }
        } else {
            return '<div style="color: red;font-size: 15pt;text-align: center">این نامه پیوست دارد</div>';
        }
        return '';
    }
}
