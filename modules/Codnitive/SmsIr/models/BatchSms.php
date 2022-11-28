<?php 
namespace app\modules\Codnitive\SmsIr\models;

use yii\helpers\Json;

class BatchSms extends Connector
{
    private const LINE_NUMBER = '3000258850';
    // private const LINE_NUMBER = '30004554552200';
    /**
     * This method can send a single SMS or group SMS through our line 
     * 
     * @param array $cellphoneNumbers   list of cellphone numbers to receive message
     * @param array $messages   list of messages for mapped to cellphone numbers
     * @return array
     */
    public function sendMessage(array $messages, array $cellphoneNumbers): array
    {
        $url = self::API_URL . 'MessageSend';
        $params =  [
            'Messages' => $messages,
            'MobileNumbers' => $cellphoneNumbers,
            'LineNumber' => self::LINE_NUMBER,
            'SendDateTime' => '',
            'CanContinueInCaseOfError' => 'false',
        ];
        return $this->jsonDecode($this->_connect($url, Json::encode($params)));
    }
}
