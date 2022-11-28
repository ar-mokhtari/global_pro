<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\reports;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\VwLetters;
use Yii;
use yii\data\ArrayDataProvider;
use yii\db\Exception;

class ShowdescriptionAction extends MainAction
{
    function run()
    {
        parent::run();
        $lettersID = $this->_getRequestPost('id');
        $model = VwLetters::find()->where(['LettersID' => $lettersID])->one();
        return $this->controller->renderAjax('../mixedreport/showLetterDetails/showdescription',
            [
                'model' => $model,
            ]
        );
    }
}
