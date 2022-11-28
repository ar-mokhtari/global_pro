<?php

namespace app\modules\Codnitive\OfficeAutomation\actions\reports;

use app\modules\Codnitive\OfficeAutomation\actions\MainAction;
use app\modules\Codnitive\OfficeAutomation\models\Referralletters;
use app\modules\Codnitive\OfficeAutomation\models\VwReferralletters;
use Yii;
use yii\db\StaleObjectException;


/**
 * LettersController implements the CRUD actions for Letters model.
 */
class ShowinreferrallettersAction extends MainAction
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
        $userID = tools()->getUser()->identity->id;
        $ReferralLettersID = Yii::$app->request->post('refid');
        $FindLetter = VwReferralletters::findOne(['ReferralLettersID' => $ReferralLettersID, 'UsersID_Receiver' => $userID]);

        if ($FindLetter->ReferralLettersReadType == 1) {
            $Update = Referralletters::findOne(['ReferralLettersID' => $ReferralLettersID, 'UsersID_Receiver' => $userID]);
            $Update->ReferralLettersReadType = 2;
            try {
                $Update->update();
            } catch (StaleObjectException $e) {
            } catch (\Throwable $e) {
            }
        }

        return $this->controller->renderAjax('../inreferralletters/show.php', [
            'model' => $FindLetter,
        ]);

    }

}