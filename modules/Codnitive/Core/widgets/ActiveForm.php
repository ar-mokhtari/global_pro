<?php
namespace app\modules\Codnitive\Core\widgets;

use yii\widgets\ActiveForm as BaseActiveForm;
use yii\widgets\ActiveFormAsset;
use yii\helpers\Json;

class ActiveForm extends BaseActiveForm
{
    /**
     * This registers the necessary JavaScript code.
     * @since 2.0.12
     */
    public function registerClientScript()
    {
        // insurance_registration[national_id][2]
        // insurance_registration-national_id-2
        $id     = $this->options['id'];
        $prefix = str_replace('_form', '', $id);
        $attributesPattern = [];
        foreach ($this->attributes as $key => $data) {
            // $index = explode('-', $data['input']);
            // if (!isset($index[2])) continue;
            // $index = $index[2];
            preg_match('/\d+/', $data['input'], $index);
            if (!isset($index[0])) continue;
            $index = $index[0];
            $name  = $data['name'];
            $this->attributes[$key]['name'] = $prefix.'['.$name.']['.$index.']';
            $this->attributes[$key]['id'] = str_replace('#', '', $this->attributes[$key]['input']);
            if ($index == 9999999999) {
                $attributesPattern[] = $this->attributes[$key];
                unset($this->attributes[$key]);
            }
        }
        if (!empty($attributesPattern)) {
            $attributesPattern = Json::htmlEncode($attributesPattern);
            $view = $this->getView();
            ActiveFormAsset::register($view);
            $view->registerJs("document.".$id."_attributes_pattern = $attributesPattern;");
        }
        return parent::registerClientScript();
    }
}
