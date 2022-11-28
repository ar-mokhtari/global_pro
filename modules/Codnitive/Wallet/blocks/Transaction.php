<?php 

namespace app\modules\Codnitive\Wallet\blocks;

use app\modules\Codnitive\Core\blocks\Template;
use app\modules\Codnitive\Calendar\models\Persian;

class Transaction extends Template
{
    public function formatDateTime(string $dateTime): string
    {
        list($date, $time) = explode(' ', $dateTime);
        $date = str_replace('-', '/', (new Persian)->getDate($date));
        $time = (new \DateTime($time))->setTimezone(new \DateTimeZone(app()->timeZone))->format('H:i');
        return implode(' ', [$date, $time]);
    }
}
