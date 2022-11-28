<?php 
function dump($var, bool $print_r = true)
{
    echo '<hr>';
    $trace = debug_backtrace()[1];
    if (isset($trace['file'])) {
        echo "{$trace['file']}: {$trace['line']}";
    }
    else {
        echo "{$trace['class']}: {$trace['function']}";
    }
    echo '<pre>';
    $print_r ? print_r($var) : var_dump($var);
    echo '</pre>';
    echo '<hr>';
}
