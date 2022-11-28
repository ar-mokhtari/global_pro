<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\Letters;
use app\modules\Codnitive\OfficeAutomation\models\Sendletters;
use dektrium\user\models\User;

class SendforusersAction extends MainAction
{
    function run()
    {
        parent::run();
        $SendLetterTransaction = Sendletters::getDb()->beginTransaction();
        $LetterTransaction = Letters::getDb()->beginTransaction();
        try {
            $model = new Sendletters();
            if ($model->load($this->_getRequestPost())) {
                $findUsers = User::find()->
                select(['id'])->
                where(['IN', 'id', $model->UsersID_FK])->all();
                foreach ($findUsers as $key => $val) {
                    $sendLetters = new Sendletters();
                    $sendLetters->UsersID_FK = $val->id;
                    $sendLetters->LettersID_FK = $model->LettersID_FK;
                    $sendLetters->SendLettersReadType = 0;
                    $sendLetters->save();
                }
                $findLetter = Letters::findOne(['LettersID' => $model->LettersID_FK]);
                $findLetter->LettersDraftType = 1;
                $findLetter->update();
                $LetterTransaction->commit();
                $SendLetterTransaction->commit();
            };
        } catch (\Exception $error) {
            $SendLetterTransaction->rollBack();
            $LetterTransaction->rollBack();
            throw new NotFoundHttpException('خطا در ارسال');
        }
    }
}
