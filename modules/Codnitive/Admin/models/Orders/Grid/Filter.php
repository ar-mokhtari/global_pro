<?php

namespace app\modules\Codnitive\Admin\models\Orders\Grid;

class Filter extends \app\modules\Codnitive\Sales\models\Account\Order\MyOrder\Grid\Filter
{
    public $cellphone;

    public function rules()
    {
        $rules = parent::rules();
        $rules[0][0][] = 'cellphone';
        return $rules;
    }
}
