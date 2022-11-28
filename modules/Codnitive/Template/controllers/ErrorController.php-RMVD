<?php

namespace app\modules\Codnitive\Template\controllers;

class ErrorController extends PageController
{
    public function actionIndex()
    {
        $exception = app()->errorHandler->exception;
        
        if ($exception !== null) {
            $name = $exception->getName();
            $this->view->title = "Error {$exception->statusCode}, {$name}";
            $this->setBodyId("error_{$exception->statusCode}");
            $this->setBodyClass("error-page {$exception->statusCode}");
            $this->layout   = "@app/modules/Codnitive/Template/views/layouts/error";
            return $this->render('/templates/error.phtml', [
                'exception' => $exception,
                'statusCode' => $exception->statusCode,
                'name' => $name,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
