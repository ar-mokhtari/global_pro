<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\reports;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\VwLetters;
use Yii;
use yii\data\ArrayDataProvider;
use yii\db\Exception;

class ShowletterAction extends MainAction
{
    function run()
    {
        parent::run();
        $lettersID = $this->_getRequestPost('id');
        $model = VwLetters::findOne(['LettersID' => $lettersID]);
        try {
            $circulation = Yii::$app->db
                ->createCommand('CALL oas_SP_InLetterID_OutCirculation(' . $lettersID . ')')
                ->queryAll();
        } catch (Exception $e) {
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $circulation,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return ($model) ? $this->controller->renderAjax('../mixedreport/showLetter',
            [
                'model' => $model,
                'dataProvider' => $dataProvider,
            ]
        ) : false;
    }
}
