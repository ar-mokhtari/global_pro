<?php

namespace app\modules\Codnitive\Core\actions;

// use Yii;
// use yii\helpers\Json;
use yii\base\Action as BaseAction;
use yii\web\Response;
// use yii\db\Transaction;

abstract class Action extends BaseAction
{
    private $_stripEscapeRequest = false;
    private $_requestPost;
    private $_requestGet;
    protected $_request;

    public function init () 
    {
        // $this->_request = $this->_getRequest();
        $this->_retriveRequest();
        app()->language = tools()->getLanguage();
        return parent::init();
    }

    private function _stripEscapeRequest()
    {
        $this->_request = tools()->stripEscapeRequest(app()->getRequest());
        $this->_requestPost = $this->_request->post();
        $this->_requestGet = $this->_request->get();
        // $this->_requestPost = tools()->recursiveStripEscapeUserInputs($this->_request->post());
        // $this->_requestGet  = tools()->recursiveStripEscapeUserInputs($this->_request->get());
        // $this->_request->setBodyParams($this->_requestPost);
        // $this->_request->setQueryParams($this->_requestGet);
    }

    protected function _retriveRequest(): self
    {
        // $this->_request = app()->getRequest();
        if (!$this->_stripEscapeRequest) {
            $this->_stripEscapeRequest();
            $this->_stripEscapeRequest = true;
        }
        return $this;
    }

    protected function _getRequest()
    {
        if (!$this->_stripEscapeRequest) {
            $this->_retriveRequest();
        }
        return $this->_request;
    }

    protected function _getRequestPost(string $filed = '')
    {
        if (!$this->_stripEscapeRequest) {
            $this->_retriveRequest();
            $this->_stripEscapeRequest = true;
        }
        if (!empty($filed)) {
            return $this->_requestPost[$filed] ?? null;
        }
        return $this->_requestPost;
    }

    protected function _getRequestGet(string $filed = '')
    {
        if (!$this->_stripEscapeRequest) {
            $this->_retriveRequest();
            $this->_stripEscapeRequest = true;
        }
        if (!empty($filed)) {
            return $this->_requestGet[$filed] ?? null;
        }
        return $this->_requestGet;
    }

    // public function beforeAction($action)
    // {
    //     $request = $this->_getRequest();
    //     app()->language = tools()->getOptionValue(
    //         'Language', 
    //         'Langi18n', 
    //         $request->get('lang', 'fa')
    //     );
    //     return parent::beforeAction($action);
    // }

    // protected function beginTransaction()
    // {
    //     return app()->db->beginTransaction(
    //         Transaction::SERIALIZABLE
    //     );
    // }

    /**
     * Method to load classes with DI container
     */
    // public function getObject(string $class)
    // {
    //     $container = new \yii\di\Container;
    //     return $container->get($class);
    // }


    public function responseRaw(string $responseData)
    {
        $response = app()->response;
        $response->format = Response::FORMAT_RAW;
        $response->data = $responseData;
        $response->statusCode = 200;
        return $response;
    }

    public function responseJson(array $responseData)
    {
        $response = app()->response;
        $response->format = Response::FORMAT_JSON;
        $response->data = $responseData;
        $response->statusCode = 200;
        return $response;
        // return $this->responseRaw(Json::encode($responseData));
    }

    public function responseImage(string $imageBase64, string $imageType = 'image/jpg')
    {
        $response = app()->response;
        $response->format = Response::FORMAT_RAW;
        $response->headers->add('content-type', $imageType);
        $response->data = $imageBase64;
        $response->statusCode = 200;
        return $response;
    }

    protected function _redirect($status = 1, $message = '')
    {
        if (!empty($message)) {
            $this->controller->setFlash($status ? 'success' : 'danger', $message);
        }
        return $this->controller->redirect($this->_redirect);
    }

    public function setFlash($type, $message)
    {
        app()->getSession()->setFlash($type, $message);
    }
}
