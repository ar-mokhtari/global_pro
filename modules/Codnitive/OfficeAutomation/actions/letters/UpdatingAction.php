<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\letters;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\blocks\LetterFrame\AddForm;
use app\modules\Codnitive\OfficeAutomation\models\Letters;
use Yii;

class UpdatingAction extends MainAction
{
    function run()
    {
        parent::run();
        $block = new AddForm();
        $data = $this->_getRequestPost();
        $lettersID = !isset($data['LettersID']) ? $data['id'] : $data['LettersID'];
        $model = Letters::findOne(['LettersID' => $lettersID]);
        if ($model->load($data)) {
            $model->LettersAbstract = $data['LettersAbstract'];
            $model->LettersSecurity = $data['LettersSecurity'];
            $model->LettersFollowType = $data['LettersFollowType'];
            $model->LettersSubject = $data['LettersSubject'];
//            $model->LettersText = $data['LettersText'];
            $model->LettersTypeOfAction = $data['LettersTypeOfAction'];
            $model->LettersResponseType = $data['LettersResponseType'];
            $model->LettersResponseDate = $data['LettersResponseDate'];
            try {
                $model->update();
            } catch (StaleObjectException $e) {
            } catch (\Exception $e) {
            } catch (\Throwable $e) {
            }
        } else {
            return $this->controller->renderAjax('updating', ['model' => $model, 'block' => $block]);
        }
    }

}
