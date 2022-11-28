<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\reports;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\Referralletters;
use dektrium\user\models\User;
use Yii;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;

/**
 * LettersController implements the CRUD actions for Letters model.
 */
class SendreferralAction extends MainAction
{

    /**
     *  * inline tags demonstration
     *
     * this function ask from Category and Content model to prepare data, then post them to view
     * @return string|void
     * @throws NotFoundHttpException
     */
    public function run()
    {
        parent::run();
        $refTransaction = Referralletters::getDb()->beginTransaction();
        try {
            $model = new Referralletters();
            if ($model->load(Yii::$app->request->post())) {
                $session = Yii::$app->session;
                $findUsers = User::find()->select(['id'])
                    ->where(['IN', 'id', $model->UsersID_Receiver])
                    ->andWhere(['NOT IN', 'id',
                        Referralletters::find()->select(['UsersID_Receiver'])
                            ->where(['LettersID_FK' => $model->LettersID_FK])->
                            andWhere(['UsersID_Sender' => tools()->getUser()->identity->id])])
                    ->all();
                if ($findUsers != null) {
                    foreach ($findUsers as $key => $val) {
                        $inserting = new Referralletters();
                        $inserting->ReferralLettersDescription = $model->ReferralLettersDescription;
                        $inserting->LettersID_FK = $model->LettersID_FK;
                        $inserting->UsersID_Sender = tools()->getUser()->identity->id;
                        $inserting->UsersID_Receiver = $val->id;
                        $inserting->ReferralLettersReadType = 0;
                        $inserting->save();
                    }
                    $refTransaction->commit();
                    $a = array('ref' => 'okk');
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