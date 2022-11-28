<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\reports;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\Referralletters;
use dektrium\user\models\User;
use Yii;

/**
 * LettersController implements the CRUD actions for Letters model.
 */
class AddreferalAction extends MainAction
{

    /**
     *  * inline tags demonstration
     *
     * this function ask from Category and Content model to prepare data, then post them to view
     * @return string|void
     */
    public function run()
    {
        parent::run();
        $session = \Yii::$app->session;
        $model = new Referralletters();
        $LetterID = Yii::$app->request->post('id');
        $findUsers = User::find()->
        select(['id', 'fullname'])->
        where(['NOT IN', 'id', tools()->getUser()->identity->id])
            ->andWhere(['NOT IN', 'id',
                Referralletters::find()->select(['UsersID_Receiver'])
                    ->where(['LettersID_FK' => $LetterID])->
                    andWhere(['UsersID_Sender' => tools()->getUser()->identity->id])])
            ->all();
        $users = array();
        foreach ($findUsers as $key => $val) {
            $users[$val->id] = $val->fullname;
        }
        return $this->controller->renderAjax('../inreferralletters/referral', [
            'model' => $model,
            'letterID' => $LetterID,
            'users' => $users,
        ]);
    }

}