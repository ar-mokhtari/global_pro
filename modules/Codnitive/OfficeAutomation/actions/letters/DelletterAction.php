<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\Letterstrash;
use app\modules\Codnitive\OfficeAutomation\models\Sendletters;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class DelletterAction extends MainAction
{
    function run()
    {
        parent::run();
        $delLetterTransaction = Sendletters::getDb()->beginTransaction();
        try {
            $letterID = $this->_getRequestPost('id');
            $userID = tools()->getUser()->identity->id;
            $newTrashLetter = new Letterstrash();
            $newTrashLetter->LettersID_FK = $letterID;
            $newTrashLetter->UsersID_FK = $userID;
            $saveStatus = ($newTrashLetter->save()) ? true : false;
            $findLetter = Sendletters::findOne(['LettersID_FK' => $letterID, 'UsersID_FK' => $userID]);
            if ($findLetter->delete() && $saveStatus) {
                $delLetterTransaction->commit();
                return Json::encode(['resMsg' => 'نامه با موفقیت حذف شد']);
            }
        } catch (\Exception $error) {
            $delLetterTransaction->rollBack();
            throw new NotFoundHttpException('خـطا: DelReciveLetter/P22');
        } catch (\Throwable $e) {
        }
    }
}
