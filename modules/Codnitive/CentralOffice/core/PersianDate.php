<?php

namespace app\modules\Codnitive\CentralOffice\core;

use app\modules\Codnitive\Calendar\models\Persian;

class PersianDate
{
    public function getPersianDate($fieldName)
    {
        $persian = new Persian();
        $dateParts = $persian->getDate(explode(' ', $fieldName)[0], false);
        $monthName = __('calendar', $persian->getMonthName($dateParts['month']));
        return "{$dateParts['day']} $monthName, {$dateParts['year']}";
    }

}