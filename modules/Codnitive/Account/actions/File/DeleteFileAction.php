<?php

namespace app\modules\Codnitive\Account\actions\File;

// use Yii;
// use yii\base\Action;
use app\modules\Codnitive\Account\actions\MainAction;
use app\modules\Codnitive\Core\models\FileManager;
use app\modules\Codnitive\Core\helpers\Data;

class DeleteFileAction extends MainAction
{
    protected $_fileManager;
    protected $_request;

    public function run()
    {
        try {
            parent::run();
            $this->_request  = tools()->stripEscapeRequest(app()->getRequest());
            $this->_fileManager = new FileManager;
            // $fileManager = new ImageManager;
            // $status = $fileManager->deleteFile($request->post('key'));
            // echo json_encode([$status]);
        }
        catch (\Exception $e) {
            $errorNumber = Data::log($e, 'AaFDF');
            return "Unknown error occurred.\n<br>$errorNumber";
        }
    }

    protected function _deleteFile()
    {
        return $this->_fileManager
            ->setKeyInfo($this->_request->post('key'))
            ->deleteFile();
    }
}
