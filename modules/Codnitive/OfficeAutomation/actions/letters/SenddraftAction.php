<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\Letters;
use app\modules\Codnitive\OfficeAutomation\models\Sendletters;
use dektrium\user\models\User;

class SenddraftAction extends MainAction
{
    function run()
    {
        parent::run();
        $lettersID = $this->_getRequestPost('id');
        $findLetter = Letters::findOne(['LettersID' => $lettersID]);
        if ($findLetter->LettersDraftType == 0) {
            $model = new Sendletters;
            $findUsers = User::find()->
            select(['id', 'username', 'fullname'])->
            where(['NOT IN', 'id', tools()->getUser()->identity->id])->all();
            $users = array();
            foreach ($findUsers as $key => $val) {
                $users[$val->id] = $val->fullname;
            }
            return $this->controller->renderAjax('Users', [
                'model' => $model,
                'users' => $users,
                'letterID' => $lettersID
            ]);

        } else {
            return '<div style="color: red;font-size: 15pt;text-align: center">این نامه قبلاً ارسال شده است</div>';
        }
    }
}
