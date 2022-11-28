<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\Referralletters;
use dektrium\user\models\User;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

class SendreferralAction extends MainAction
{
    function run()
    {
        parent::run();
        $refTransaction = Referralletters::getDb()->beginTransaction();
        try {
            $userID = tools()->getUser()->identity->id;
            $model = new Referralletters();
            if ($model->load($this->_getRequestPost())) {
                $findUsers = User::find()->select(['id'])
                    ->where(['IN', 'id', $model->UsersID_Receiver])
                    ->andWhere(['NOT IN', 'id',
                        Referralletters::find()->select(['UsersID_Receiver'])
                            ->where(['LettersID_FK' => $model->LettersID_FK])->
                            andWhere(['UsersID_Sender' => $userID])])
                    ->all();
                if ($findUsers != null) {
                    foreach ($findUsers as $key => $val) {
                        $inserting = new Referralletters();
                        $inserting->ReferralLettersDescription = $model->ReferralLettersDescription;
                        $inserting->LettersID_FK = $model->LettersID_FK;
                        $inserting->UsersID_Sender = $userID;
                        $inserting->UsersID_Receiver = $val->id;
                        $inserting->ReferralLettersReadType = 0;
                        $inserting->save();
                    }
                    $refTransaction->commit();
                    $a = array('ref' => 'ok');
                    return Json::encode($a);
                } else {
                    $refTransaction->rollBack();
                    $a = array('ref' => 'no');
                    return Json::encode($a);
                }
            }
        } catch (\Exception $error) {
            $refTransaction->rollBack();
            throw new NotFoundHttpException('خـطا: ReferralLetter/P23');
        }
    }
}
