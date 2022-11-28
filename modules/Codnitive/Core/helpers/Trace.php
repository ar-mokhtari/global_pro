<?php
namespace app\modules\Codnitive\Core\helpers;

class Trace
{
    public static function getCallingMethodName()
    {
        $dbt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        return isset($dbt[2]['function']) ? $dbt[2]['function'] : null;
    }
}
