<?php

namespace app\modules\Codnitive\Language\models\System\Source;

class Langi18n extends \app\modules\Codnitive\Core\models\System\Source\OptionsArray
{
    public function optionsArray(): array
    {
        return [
            'def' => 'fa-IR',
            'en'  => 'en-US',
            'fa'  => 'fa-IR',
        ];
    }
}
