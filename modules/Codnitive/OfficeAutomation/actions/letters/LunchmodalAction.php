<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\blocks\LetterFrame\AddForm;
use app\modules\Codnitive\OfficeAutomation\models\Letters;
use Yii;
use yii\web\UploadedFile;

class LunchmodalAction extends MainAction
{
    function run()
    {
        parent::run();
        $transaction = Letters::getDb()->beginTransaction();
        try {
            $data = $this->_getRequestPost();
            $model = new Letters();
            if ($model->load(Yii::$app->request->post())) {
                $model->UsersID_FK = tools()->getUser()->identity->id;
                $model->LettersSecurity = $data['LettersSecurity'];
                $model->LettersTypeOfAction = $data['LettersTypeOfAction'];
                $model->LettersAbstract = $data['LettersAbstract'];
                $model->LettersFollowType = $data['LettersFollowType'];
                $model->LettersSubject = $data['LettersSubject'];
                $model->LettersResponseType = $data['LettersResponseType'];
                $model->LettersResponseDate = $data['LettersResponseDate'];
                $model->LettersType = 0;//this means letter is not answer and letter is main
                $model->LettersNumber = tools()->ToLatina(time());
                $model->LettersDraftType = 0;//this means letter status is Temp
                $model->LettersAttachmentType = 0;//means letter not attachment by default
                $model->LettersAttachmentUrl = '';
                $model->LettersAttachmentFileName = '';
                $model->LettersArchiveType = 0;//means not archive;
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $model->LettersAttachFileExtention = '';
                if (!empty($model->imageFile)) {
                    $fileName = sha1(time() . $model->imageFile->baseName);
                    $model->imageFile->
                    saveAs('office/upload/' . $fileName . '.' . $model->imageFile->extension);
                    $model->LettersAttachmentType = 1;//means letter have attachment
                    $model->LettersAttachmentUrl = $fileName . '.' . $model->imageFile->extension;
                    $model->LettersAttachmentFileName =
                        $model->imageFile->baseName . '.' . $model->imageFile->extension;
                    $model->LettersAttachFileExtention = $model->imageFile->extension;
                }
                if ($model->save()) {
                    $transaction->commit();
                }
            }
            $block = (new AddForm());
            return $this->controller->renderAjax('create',
                [
                    'model' => $model,
                    'block' => $block,
                ]
            );
        } catch (\Exception $e) {
            $this->setFlash('danger', $e->getMessage());
        }
    }

}
