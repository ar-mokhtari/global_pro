<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\Letters;
use app\modules\Codnitive\OfficeAutomation\models\Sendletters;
use yii\db\StaleObjectException;


class SendanswerAction extends MainAction
{
    function run()
    {
        parent::run();
        //read form send data (post)
        list($letterID, $letterReferenceID, $userID) =
            [
                $this->_getRequestPost('id'),
                $this->_getRequestPost('rid'),
                $this->_getRequestPost('userid')
            ];
        $sendLetterDate = '';
        $readType = 0;
        //insert into "sendLetter" new record of answer
        $SendLetterModel = new Sendletters();
        $SendLetterModel->LettersID_FK = $letterID;
        $SendLetterModel->UsersID_FK = $userID;
        $SendLetterModel->SendLettersReadType = $readType;
        $SendLetterModel->save();
        //update letter to main status because of sent
        $FindLetterModel = Letters::findOne(['LettersID' => $letterID]);
        $FindLetterModel->LettersDraftType = 1;
        try {
            $FindLetterModel->update();
        } catch (StaleObjectException $e) {
        } catch (\Throwable $e) {
        }
    }
}
