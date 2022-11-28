<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\CentralOffice\models\Users;
use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\Referralletters;
use dektrium\user\models\User;


class ReferrallettersAction extends MainAction
{
    function run()
    {
        parent::run();
        $model = new Referralletters();
        $LetterID = $this->_getRequestPost('id');
        $userID = tools()->getUser()->identity->id;
        $findUsers = User::find()->
        select(['id', 'username', 'fullname'])->
        where(['NOT IN', 'id', $userID])
            ->andWhere(['NOT IN', 'id',
                Referralletters::find()->select(['UsersID_Receiver'])
                    ->where(['LettersID_FK' => $LetterID])->
                    andWhere(['UsersID_Sender' => $userID])])
            ->all();
        $users = array();
        foreach ($findUsers as $key => $val) {
            $users[$val->id] = $val->username;
        }
        return $this->controller->renderAjax('../recieveletter/referral', [
            'model' => $model,
            'letterID' => $LetterID,
            'users' => $users,
        ]);
    }
}
