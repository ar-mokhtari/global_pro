<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\Letters;
use Yii;
use yii\widgets\ActiveForm;

class CheckresponseAction extends MainAction
{
    function run()
    {
        parent::run();
        $model = new Letters;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = 'json';
            return ActiveForm::validate($model);
        } else {
            return false;
        }
    }

}
