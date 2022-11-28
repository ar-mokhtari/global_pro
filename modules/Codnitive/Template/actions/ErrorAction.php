<?php

namespace app\modules\Codnitive\Template\actions;

class ErrorAction extends \app\modules\Codnitive\Core\actions\Action
{
    public function run()
    {
        $exception = app()->errorHandler->exception;
        
        if ($exception !== null) {
            $name = $exception->getName();
            $this->controller->view->title = "Error {$exception->statusCode}, {$name}";
            $this->controller->setBodyId("error_{$exception->statusCode}");
            $this->controller->setBodyClass("error-page {$exception->statusCode}");
            $this->controller->layout   = "@app/modules/Codnitive/Template/views/layouts/error";
            return $this->controller->render('/templates/simple_error.phtml', [
                'exception' => $exception,
                'statusCode' => $exception->statusCode,
                'name' => $name,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
