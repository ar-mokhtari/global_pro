<?php

namespace app\modules\Codnitive\Account\actions\File;

// use Yii;
use yii\helpers\Json;
// use yii\base\Action;
// use app\modules\Codnitive\Account\actions\MainAction;
use app\modules\Codnitive\Core\models\ImageManager;
use app\modules\Codnitive\Core\helpers\Data;

class DeleteImageAction extends DeleteFileAction/*MainAction*/
{
    public function run()
    {
        try {
            parent::run();
            $this->_fileManager = new ImageManager;
            $status = $this->_deleteFile();
            // $status = $this->_deleteImageFile();
            // return json_encode([$status]);
            return Json::encode([$status]);
        }
        catch (\Exception $e) {
            // echo '<pre>';
            // print_r($e);
            // echo $e->getMessage();
            $errorNumber = Data::log($e, 'AaFDI');
            return "Unknown error occurred.\n<br>$errorNumber";
        }
    }

    // protected function _deleteImageFile()
    // {
    //     $request  = tools()->stripEscapeRequest(app()->getRequest());
    //     $fileManager = new ImageManager;
    //     return $fileManager->deleteFile($request->post('key'));
    // }
}
