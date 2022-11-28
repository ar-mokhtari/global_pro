<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\Sendletters;
use app\modules\Codnitive\OfficeAutomation\models\VwRecieveletter;


class ShowletterAction extends MainAction
{
    function run()
    {
        parent::run();
        $userID = tools()->getUser()->identity->id;
        $lettersID = $this->_getRequestPost('id');
        $model = VwRecieveletter::findOne(['LettersID' => $lettersID, 'UsersID_Reciever' => $userID]);
        if ($model) {
            $vwLetter = Sendletters::findOne(['LettersID_FK' => $lettersID, 'UsersID_FK' => $userID]);
            switch ($vwLetter->SendLettersReadType) {
                case 0:
                    $vwLetter->SendLettersReadType = 1;
                    $vwLetter->update();
            }
            return $this->controller->renderAjax('../recieveletter/showLetter', ['model' => $model]);
        }
    }
}
