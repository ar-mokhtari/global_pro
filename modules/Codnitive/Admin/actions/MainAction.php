<?php

namespace app\modules\Codnitive\Admin\actions;

// use yii\base\Action;
use app\modules\Codnitive\Core\actions\Action as CoreAction;

class MainAction extends CoreAction
{

    public function run()
    {
        $this->controller->setBodyId('page-top');
        $this->controller->setBodyClass('fixed-nav sticky-footer bg-dark admin panel');
        $this->controller->layout = '@app/modules/Codnitive/Admin/views/layouts/main';
    }

    public function getErrorsMessage($model)
    {
        if (is_string($model)) {
            return $model;
        }
        $html = '<ul class="errors-message">';
        foreach ($model->getErrors() as $errors) {
            foreach ($errors as $error) {
                $html .= "<li>$error</li>";
            }
        }
        return $html .= '</ul>';
    }

}
