<?php 
namespace app\modules\Codnitive\SmsIr\models;

use yii\helpers\Json;
use app\modules\Codnitive\Core\helpers\Curl;
use app\modules\Codnitive\Core\helpers\Trace;

abstract class Connector
{
    private const SECURITY_CODE = '';
    private const API_KEY       = '';
    public  const API_URL       = 'https://RestfulSms.com/api/';
    public  const TOKEN_URL     = 'https://RestfulSms.com/api/Token';

    protected $curlClient;
    protected $_params = [];
    protected $_cacheMethods = [
        'setToken' => 60 * 30, 
    ];

    private $_token;

    public function getClient()
    {
        // if (!$this->curlClient) {
            $this->curlClient = new Curl;
        // }
        return $this->curlClient;
    }

    protected function _connect(string $url, string $params = '', array $header = [], string $method = 'POST')
    {
        // if (!$this->curlClient) {
        //     $this->curlClient = new Curl;
        // }

        if (empty($header)) {
            $token = $this->getToken();
            if (empty($token)) {
                return false;
            }
            $header = [
                'Content-Type: application/json',
                'x-sms-ir-secure-token: ' . $token
            ];
        }

        try {
            $this->getClient();
            $this->curlClient->setUrl($url)
                ->setHeader($header)
                ->setParams($params)
                ->setMethod($method);

            $function = Trace::getCallingMethodName();
            if (array_key_exists($function, $this->_cacheMethods)) {
                // $key      = __CLASS__ . "::$function";
                $this->curlClient->setCache(true, floatval($this->_cacheMethods[$function]));
            }
            
            return $this->curlClient->connect()->exec();
        }
        catch (\Exception $e) {
            $errorNumber = \app\modules\Codnitive\Core\helpers\Data::log($e, 'I-SI_m_C');
            // @todo message notice
            return false;
            // var_dump($e);
        }
    }

    public function setToken(): self
    {
        $header = [
            'Content-Type:  application/json'
        ];
        $params = [
            'SecretKey'  => self::SECURITY_CODE,
            'UserApiKey' => self::API_KEY
        ];
        $params = Json::encode($params);
        $token = $this->jsonDecode(
            $this->_connect(self::TOKEN_URL, $params, $header)
        );
        $this->_token = $token['TokenKey'] ?? '';
        return $this;
    }

    public function getToken(): string
    {
        if (!$this->_token) {
            $this->setToken();
        }
        return $this->_token;
    }

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

    protected function jsonDecode(string $json): array
    {
        try {
            $result = Json::decode($json);
            if (!is_array($result) || $result['IsSuccessful'] != true) {
                throw new \Exception($result['Message']);
            }
            return $result;
        }
        catch (\Exception $e) {
            return [];
        }
    }
}
