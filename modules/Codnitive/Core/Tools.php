<?php 

function tools()
{
    if (!isset(\app()->params['tools'])) {
        \app()->params['tools'] = new \app\modules\Codnitive\Core\helpers\Tools;
    }
    return \app()->params['tools'];
}
