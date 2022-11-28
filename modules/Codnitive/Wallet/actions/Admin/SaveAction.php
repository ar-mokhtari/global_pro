<?php

namespace app\modules\Codnitive\Wallet\actions\Admin;

use app\modules\Codnitive\Admin\actions\MainAction;
use app\modules\Codnitive\Wallet\models\Admin\EditForm;

class SaveAction extends MainAction
{
    /**
     * Disbale CSRF validation
     */
    // public function init()
    // {
    //     parent::init();
    //     app()->controller->enableCsrfValidation = false;    
    // }
    
    public function run()
    {
        $model = new EditForm($this->_getRequest()->post());
        if (!$model->validate()) {
            $this->setFlash('danger', $model->getErrorsMessage());
            return $this->controller->redirect(tools()->getPreviousUrl());
        }
        
        try {
            $model->saveCredit();
        }
        catch (\yii\db\Exception $e) {
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'I-W_a_A_SA');
            $msg = "Internal error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
        }
        catch (\Exception $e) {
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'G-W_a_A_SA');
            $msg = "General error occurred.\n<br>$errorNumber";
            $this->setFlash('danger', __('core', $msg));
        }

        $this->setFlash('success', __('wallet', 'User Credit Updated Successfully.'));
        return $this->controller->redirect(tools()->getPreviousUrl());
    }
}
