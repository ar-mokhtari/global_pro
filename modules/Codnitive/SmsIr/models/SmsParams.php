<?php
namespace app\modules\Codnitive\SmsIr\models;

use yii\base\Event;

class SmsParams extends Event
{
    /**
     * Template ID for send fast white SMS 
     * 
     * @var int
     */
    public $templateId  = 0;

    /**
     * Cellphone number to send fast white SMS
     * Cellphone mubers to send batch SMS
     * 
     * @var string|array
     */
    public $cellphone   = '';

    /**
     * Parameters and values for vairables in message template
     * 
     * @var array
     */
    public $params      = [];

    /**
     * Message(s) to send with batch SMS
     * 
     * @var string|array
     */
    public $messages    = '';

    /**
     * Defines batch SMS API to send SMS
     * 
     * @var bool
     */
    public $forceUseBatchSms = false;
}
