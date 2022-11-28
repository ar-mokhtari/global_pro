<?php

namespace app\modules\Codnitive\Account\models;

class Mailer extends \dektrium\user\Mailer
{
    /**
     * @param string $to
     * @param string $subject
     * @param string $view
     * @param array  $params
     *
     * @return bool
     */
    protected function sendMessage($to, $subject, $view, $params = [])
    {
        return true;
    }
}
