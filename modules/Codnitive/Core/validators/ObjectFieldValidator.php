<?php

namespace app\modules\Codnitive\Core\validators;

use yii\validators\Validator;

class ObjectFieldValidator extends Validator
{
    protected $_modelClass = '';

    public function validateAttribute($model, $attribute) 
    {
        if (!empty($this->_modelClass)) {
            $modelObject = \Yii::createObject($this->_modelClass, [$model->$attribute]);
            if(!$modelObject->validate()) {
                $model->addErrors($modelObject->getErrors()); 
            }
        }
    }
}
