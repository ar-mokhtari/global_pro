<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\Calendar\models\Persian;
use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\Letters;
use app\modules\Codnitive\OfficeAutomation\models\VwRecieveletter;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


class AnswerlettersAction extends MainAction
{
    public $responseLetterID;
    public $letterNumber;
    public $letterSender;
    public $letterDate;

    function run()
    {
        parent::run();
        $transaction = Letters::getDb()->beginTransaction();
        try {
            $model = new Letters();
            if ($model->load(\Yii::$app->request->post())) {
                $model->LettersType = 1;//this means letter is  answer and letter is main
                $model->UsersID_FK = tools()->getUser()->identity->id;
                $model->LettersNumber = tools()->ToLatina(time());
                $model->LettersDraftType = 0;//this means letter status is Temp
                $model->LettersAttachmentType = 0;//means letter not attachment by default
                $model->LettersAttachmentUrl = '';
                $model->LettersAttachmentFileName = '';
                $model->LettersArchiveType = 0;//means not archive;
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if (!empty($model->imageFile)) {
                    $fileName = sha1(time() . $model->imageFile->baseName);
                    $model->imageFile->
                    saveAs('upload/' . $fileName . '.' . $model->imageFile->extension);
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
            $letter = \Yii::$app->request->post('id');
            if ($letter) {
                $FindResponse = Letters::findOne(['LettersResponseID' => $letter]);
                $CheckDate = Letters::findOne(['LettersID' => $letter]);
                if ($FindResponse) {
                    return
                        '<h5 style="text-align: center;color: red">
                                   برای این نامه پاسخ نامه ارسال شده است و یا پیش‌نویس آن تهیه شده است
                         </h5>';
                }
                //todo debug all persian date like this:
/*                  if ($CheckDate->LettersResponseType == 0
                    && $CheckDate->LettersResponseDate < $this->ToLatina(Jdf::jdate('Y/m/d'))) {
                    return '<h5 style="text-align: center;color: red">مهلت پاسخ نامه گذشته است</h5>';
                }*/
                $findLetter = VwRecieveletter::findOne(['LettersID' => $letter]);
                $this->responseLetterID = $letter;
                $this->letterNumber = $findLetter->LettersNumber;
                $this->letterSender = $findLetter->FullNameSender;
            }
            return $this->controller->renderAjax('../recieveletter/answer', [
                'model' => $model,
                'responseLetterID' => $this->responseLetterID,
                'letterNumber' => $this->letterNumber,
                'letterSender' => $this->letterSender,
                'letterSendDate' => $this->letterDate,
            ]);
        } catch (\Exception $error) {
            $transaction->rollBack();
            throw new NotFoundHttpException('خـطا: AnswerLetter/P21');
        }
    }
}
