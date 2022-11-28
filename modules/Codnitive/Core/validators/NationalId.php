<?php

namespace app\modules\Codnitive\Core\validators;

use yii\validators\Validator;
use app\modules\Codnitive\Core\helpers\Rules;

// @link http://www.aliarash.com/article/codemeli/codemeli.htm
// @link https://github.com/mhfeizi/yii2-iranian-national-code-validator
class NationalId extends Validator
{
    protected $_invalidIds = [
        '0000000000',
        //'1111111111', // this national id can be validate
        '2222222222',
        '3333333333',
        '4444444444',
        '5555555555',
        '6666666666',
        '7777777777',
        '8888888888',
        '9999999999'
    ];

    public function init() 
    {
        if ($this->message == null) {
            $this->message = __('core', '{attribute} is not valid.');
        }
    }

    public function validateValue($value) 
    {
        $value = tools()->addLeadingZero($value, 10);
        $firstInvalidationCheck = !is_string($value) || (1 !== preg_match(Rules::IRANIAN_NATIONAL_ID, $value))
            || (0 === strpos($value, '000')) || in_array ($value, $this->_invalidIds);
    	if ($firstInvalidationCheck) {
    		return [
                $this->message,
                []
    		];
        }
        
    	$sum = $i = 0;
    	while ($i < 10) {
    		$sum += intval($value[$i]) * (10 - $i);
    		++$i;
    	}
    	$sum = ($sum - intval($value[9])) % 11;
    	if ($sum >= 2) {
    		$sum = 11 - $sum;
    	}
    	if ($sum !== intval($value[9])) {
    		return [
                $this->message,
                []
    		];
    	}
    	return null;
    }

    public function clientValidateAttribute($model, $attribute, $view) 
    {
        $message = app()->getI18n()->format(
            $this->message, ['attribute' => $model->getAttributeLabel($attribute)], app()->language
        );
        $message = json_encode($message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $pattern = trim(Rules::IRANIAN_NATIONAL_ID_JS, '/');

        $js = <<<JS
            let regex = new RegExp('{$pattern}');
            if(!regex.exec(value)){
                messages.push($message);
            }
            else{
                let invalidIds = [
                    '0000000000',
                    //'1111111111', // this national id can be validate
                    '2222222222',
                    '3333333333',
                    '4444444444',
                    '5555555555',
                    '6666666666',
                    '7777777777',
                    '8888888888',
                    '9999999999'
                ];
                if($.inArray(value, invalidIds) >= 0){
                    messages.push($message);
                }
                else{
                    let sum = i = 0;
                    while (i < 10) {
                        sum += parseInt(value[i]) * (10 - i);
                        ++i;
                    }
                    sum = (sum - parseInt(value[9])) % 11;
                    if(sum >= 2){
                        sum = 11 - sum;
                    }
                    if(sum != parseInt(value[9])){
                        messages.push($message);
                    }
                }
            }
JS;
        if ($this->skipOnEmpty) {
            $js = "if(value !== ''){ {$js} }";
        }
        return $js;
    }
}
