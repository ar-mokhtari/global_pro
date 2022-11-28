<?php


namespace app\modules\Codnitive\OfficeAutomation\core\models;


class FileManager extends \app\modules\Codnitive\Core\models\FileManager
{
    public function upload()
    {
        // if ($this->validate()) {
        $uploaded = [];
        foreach ($this->_fields as $field) {
            $files = self::getInstances($this->_model, $field);
            $uploaded[$field] = [];
            foreach ($files as $key => $file) {
                $fileName = $this->_getFileName($file);
                // if($file->saveAs($this->getUploadDir() . $fileName)) {
                $uploaded[$field][$key] = [
                    'name' => $fileName,
                    'size' => $file->size,
                    'type' => $file->type,
                    // 'path' => $this->_getPath(),
                    'save' => $file->saveAs($this->getUploadDir() . $fileName, false)
                ];
                // }
            }
            // if (empty($uploaded[$field])) {
            //     unset($uploaded[$field]);
            // }
        }
        return $uploaded;
        // }
        // return false;
    }

    private function _getFileName($fileData)
    {
        if (empty($fileData->tempName)) {
            return '';
        }
        $tempParts = explode('/', $fileData->tempName);
        $nameParts = explode('.', $fileData->name);
        $extension = array_pop($nameParts);
        $name = implode('.', $nameParts);
        return time() . '_' . $name . '.' . $extension;
    }

}