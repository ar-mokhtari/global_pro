<?php

namespace app\modules\Codnitive\Core\helpers;

// use yii\web\ServerErrorHttpException;
use app\modules\Codnitive\Core\helpers\Data;

class Soap
{
    private $_url      = '';
    private $_header   = ['version' => SOAP_1_2];
    private $_context  = [];
    private $_cache    = false;
    private $_lifeTime = 60 * 10;
    private $_timeout  = 2;

    private $_client;

    public function __construct(string $wsdlUrl = '', array $header = [],  array $context = [])
    {
        $this->setUrl($wsdlUrl);
        $this->setHeader($header);
        $this->setContext($context);
    }

    public function setUrl(string $wsdlUrl): self
    {
        $this->_url = $wsdlUrl;
        return $this;
    }

    public function setHeader(array $header): self
    {
        $this->_header = $header;
        return $this;
    }

    public function setContext(array $context): self
    {
        $this->_context = $context;
        return $this;
    }

    public function setCache(bool $cache, int $lifeTime = 60 * 10): self
    {
        $this->_cache    = $cache;
        $this->_lifeTime = $lifeTime;
        return $this;
    }

    // public function getClient()
    // {
    //     return $this->_client;
    // }

    /**
     * @param   context     connection options
     */
    public function connect(string $wsdlUrl = '', array $context = [])
    {
        // $url     = $wsdlUrl ?? $this->_url;
        // $context = $context ?? $this->_context;
        if (!empty($wsdlUrl)) {
            $this->setUrl($wsdlUrl);
        }
        if (!empty($context)) {
            $this->setContext($context);
        }
        $header  = $this->_header;
        if (!empty($context)) {
            $header['context'] = stream_context_create($this->_context);
        }
        try {
            // @link https://stackoverflow.com/questions/3500527/php-soapclient-timeout
            $original = ini_get('default_socket_timeout');
            ini_set('default_socket_timeout', $this->_timeout);
            if (!isset($header['connection_timeout'])) {
                $header['connection_timeout'] = $this->_timeout;
            }    
            $this->_client = new \SoapClient($this->_url, $header);
            ini_set('default_socket_timeout', $original);
        }
        catch (\Exception $e) {
            $errorNumber = Data::log($e, 'ChS');
            Data::setFlash('danger', __('core', 'Error occurred when soap connection.<br>'.$errorNumber));
            throw new \Exception('Error occurred when soap connection.<br>'.$errorNumber);
        }
        return $this->_client;
        // return $this;
    }

    public function _call(string $function, array $params = [])
    {
        $cacheKey = $this->_getCacheKey($function, $params);
        if (($cacheValue = Cache::getCacheData($cacheKey)) !== false) {
            // var_dump('from_cache');
            return $cacheValue;
        }

        $params = [$function => $params];
        try {
            $result = $this->connect()->__soapCall($function, $params);
        }
        catch (\Exception $e) {
            // replace with flash alert message
            Data::setFlash('danger', __('core', 'Error occurred when execute connection.<br>'.$e->getMessage()));
            // throw new ServerErrorHttpException($e->getMessage());
            $result = null;
        }

        if ($this->_cache && $result) {
            Cache::setCacheData($cacheKey, $result, $this->_lifeTime);
        }
        return $result;
    }
    
    private function _getCacheKey(string $function, array $params): string 
    {
        $key = $this->_url . "::$function";
        $cacheParams = [
            'url'     => $this->_url,
            'params'  => $params,
            'header'  => $this->_header,
            'context' => $this->_context
        ];
        $params = [$key => $cacheParams];
        return Cache::getCacheKey($params);
    }
    
}
