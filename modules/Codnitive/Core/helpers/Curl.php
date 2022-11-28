<?php

namespace app\modules\Codnitive\Core\helpers;

// use yii\web\ServerErrorHttpException;
use app\modules\Codnitive\Core\helpers\Data;
use app\modules\Codnitive\Core\helpers\Cache;

class Curl
{
    private $_url    = '';
    private $_method = 'POST';
    private $_header = [];
    private $_params = '';
    private $_cache  = false;
    private $_lifeTime = 60 * 10;
    private $_timeout = 90;

    private $_ch;

    public function __construct(string $url = '', array $header = [],  string $params = '',  $method = 'POST')
    {
        $this->setUrl($url);
        $this->setMethod($method);
        $this->setHeader($header);
        $this->setParams($params);
    }

    public function setUrl(string $url): self
    {
        $this->_url = $url;
        return $this;
    }

    public function setMethod(string $method): self
    {
        $this->_method = $method;
        return $this;
    }

    public function setHeader(array $header): self
    {
        $this->_header = $header;
        return $this;
    }

    public function setCache(bool $cache, int $lifeTime = 60 * 10): self
    {
        $this->_cache    = $cache;
        $this->_lifeTime = $lifeTime;
        return $this;
    }

    public function setParams(string $params): self
    {
        $this->_params = $params;
        return $this;
    }

    public function connect(string $url = ''): self
    {
        $url = !empty($url) ? $url : $this->_url;
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->_method);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->_timeout);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->_timeout);
            if (!empty($this->_params)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_params);
            }
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_header);

            $this->_ch = $ch;
        }
        catch (\Exception $e) {
            $errorNumber = Data::log($e, 'ChC');
            Data::setFlash('danger', __('core', 'Error occurred when curl connection.<br>'.$errorNumber));
            // throw new ServerErrorHttpException($errorNumber);
        }

        return $this;
    }

    public function exec()
    {
        $cacheKey = $this->_getCacheKey();
        if (($cacheValue = Cache::getCacheData($cacheKey)) !== false) {
            // var_dump('from_cache');
            return $cacheValue;
        }

        try {
            $response = curl_exec($this->_ch);
            $error    = curl_error($this->_ch);
            curl_close($this->_ch);
            if ($error) {
                throw new \Exception($error);
            }

            if ($this->_cache) {
                Cache::setCacheData($cacheKey, $response, $this->_lifeTime);
            }
        }
        catch (\Exception $e) {
            $errorNumber = Data::log($e, 'ChC');
            Data::setFlash('danger', __('core', 'Error occurred when execute connection.<br>'.$errorNumber));
            // throw new ServerErrorHttpException($errorNumber);
            // throw new \Exception($e);
        }

        return $response;
    }
    
    private function _getCacheKey(): string 
    {
        $cacheParams = [
            'url'    => $this->_url,
            'data'   => $this->_params,
            'header' => $this->_header,
            'method' => $this->_method
        ];
        $params = [$this->_url => $cacheParams];
        return Cache::getCacheKey($params);
    }

    // public function connectOLDONE($url,  $method, array $header,  $params = '')
    // {
    //     try {
    //         $ch = curl_init($url);
    //         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    //         if (!empty($params)) {
    //             curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    //         }
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    //         $response = curl_exec($ch);
    //         $error    = curl_error($ch);
    //         curl_close($ch);
    //         if ($error) {
    //             $helper = new Data();
    //             $helper->printo('{"warning": "' . $error . '"}');
    //             throw new \Exception($error);
    //         }
    //     }
    //     catch (\Exception $e) {
    //         $helper = new Data();
    //         $helper->printo('{"warning": "' . $error . '"}');
    //         $errorNumber = Data::log($e, 'ChC');
    //         throw new ServerErrorHttpException($errorNumber);
    //         // throw new \Exception($e->getMessage());
    //     }

    //     return $response;
    // }
    
}
