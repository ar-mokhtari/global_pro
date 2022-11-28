<?php 
namespace app\modules\Codnitive\SmsIr\models;

use yii\helpers\Json;

class WhiteSms extends Connector
{
    /**
     * This method can send fast SMS thourgh provider registerd line with pre defined 
     * SMS templates
     * 
     * @param int $templateId
     * @param string $cellphoneNumber   user's cellphone number
     * @param array $parameters     template vairables values
     * @return array
     */
    public function ultraFastSend(int $templateId, string $cellphoneNumber, array $parameters): array
    {
        $url = self::API_URL . "UltraFastSend";
        $params =  [
            "ParameterArray" => $parameters,
            "Mobile" => $cellphoneNumber,
            "TemplateId" => $templateId
        ];
        return $this->jsonDecode($this->_connect($url, Json::encode($params)));
    }
}
