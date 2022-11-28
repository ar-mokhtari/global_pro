<?php
/**
 * Copyright © Codnitive, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace app\modules\Codnitive\Calendar\models;

class Gregorian
{

    public function __construct()
    {
        app()->getModule(\app\modules\Codnitive\Calendar\Module::MODULE_ID);
    }

    public function getDate(string $persianDate, $format = 'Y-m-d', string $separator = '-')
    {
        list($year, $month, $day) = explode($separator, $persianDate);
        $jdn    = (new Persian)->dateToJdn($year, $month, $day);
        $parts  = $this->jdnToDate($jdn);
        $mMonth = sprintf('%02d', $parts['month']);
        $dDay   = sprintf('%02d', $parts['day']);
        $yYear  = substr($parts['year'], -2, 2);
        return $format 
            ? str_replace(
                ['Y',            'y',    'm',     'd',   '-'], 
                [$parts['year'], $yYear, $mMonth, $dDay, $separator], 
                $format
            )
            : $parts;
    }

    public function jdnToDate(float $jdn): array
    {
        $l = $jdn + 68569;
        $n = (int) ((4 * $l) / 146097);
        $l = $l - (int) ((146097 * $n + 3) / 4);
        $i = (int) ((4000 * ($l + 1)) / 1461001);
        $l = $l - (int) ((1461 * $i) / 4) + 31;
        $j = (int) ((80 * $l) / 2447);
        $day = $l - (int) ((2447 * $j) / 80);
        $l = (int) ($j / 11);
        $month = $j + 2 - 12 * $l;
        $year = 100 * ($n - 49) + $i + $l;

        return array('year' => (int) $year, 'month' => (int) $month, 'day' => (int) $day);
    }

    public function dateToJdn(int $year, int $month, int $day): float
    {
        $jdn = (int) ((1461 * ($year + 4800 + (int) (($month - 14) / 12))) / 4)
                + (int) ((367 * ($month - 2 - 12 * ((int) (($month - 14) / 12)))) / 12)
                - (int) ((3 * ((int) (($year + 4900 + (int) (($month - 14) / 12)) / 100))) / 4)
                + $day - 32075;

        return (float) $jdn;
    }

    public function isLeapYear(int $year): bool
    {
        return (($year % 4) == 0) && (!((($year % 100) == 0) && (($year % 400) != 0)));
    }

}
