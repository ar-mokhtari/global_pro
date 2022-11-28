<?php

namespace app\modules\Codnitive\Core\models;

use Yii;
// use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\Json;
// use app\modules\Codnitive\Core\helpers\Tools;

class FileManager extends UploadedFile
{
    /**
     * @var UploadedFile[]
     */
    // protected $_files;

    const VALID_IMAGE_EXSTENSIONS = 'jpg,jpeg,png';
    const VALID_MEDIA_EXSTENSIONS = 'jpg,jpeg,png,avi,mp4,mkv';

    protected $_model;
    protected $_fields;
    protected $_settings;
    protected $_basePath;
    protected $_userId;
    protected $_fileToDelete;
    protected $_fieldToDelete;

    private static $_files;

    protected function _init()
    {
        $this->_basePath = app()->basePath . $this->_baseDir;
        $this->_userId   = tools()->getUser()->id;
        return $this;
    }

    protected function _getPath()
    {
        return $this->_basePath . $this->_userId . '/';
    }

    public function setUploadData($model, array $fields, $settings = [])
    {
        $this->_model    = $model;
        $this->_fields   = $fields;
        $this->_settings = $settings;
        $this->_init();
        return $this;
    }

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
                            'save' => $file->saveAs($this->getUploadDir() . $fileName)
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

    /**
     * Returns an array of uploaded files corresponding to the specified file input name.
     * This is mainly used when multiple files were uploaded and saved as 'files[0]', 'files[1]',
     * 'files[n]'..., and you can retrieve them all by passing 'files' as the name.
     * @param string $name the name of the array of files
     * @return UploadedFile[] the array of UploadedFile objects. Empty array is returned
     * if no adequate upload was found. Please note that this array will contain
     * all files from all sub-arrays regardless how deeply nested they are.
     */
    public static function getInstancesByName($name)
    {
        $files = self::loadFiles();
        if (isset($files[$name])) {
            return [new static($files[$name])];
        }
        $results = [];
        foreach ($files as $key => $file) {
            if (strpos($key, "{$name}[") === 0) {
                $index = rtrim(str_replace("{$name}[", '', $key), ']');
                $results[$index] = new static($file);
            }
        }

        return $results;
    }

    /**
     * Creates UploadedFile instances from $_FILE.
     * @return array the UploadedFile instances
     */
    private static function loadFiles()
    {
        if (self::$_files === null) {
            self::$_files = [];
            if (isset($_FILES) && is_array($_FILES)) {
                foreach ($_FILES as $class => $info) {
                    self::loadFilesRecursive($class, $info['name'], $info['tmp_name'], $info['type'], $info['size'], $info['error']);
                }
            }
        }

        return self::$_files;
    }

    /**
     * Creates UploadedFile instances from $_FILE recursively.
     * @param string $key key for identifying uploaded file: class name and sub-array indexes
     * @param mixed $names file names provided by PHP
     * @param mixed $tempNames temporary file names provided by PHP
     * @param mixed $types file types provided by PHP
     * @param mixed $sizes file sizes provided by PHP
     * @param mixed $errors uploading issues provided by PHP
     */
    private static function loadFilesRecursive($key, $names, $tempNames, $types, $sizes, $errors)
    {
        if (is_array($names)) {
            foreach ($names as $i => $name) {
                self::loadFilesRecursive($key . '[' . $i . ']', $name, $tempNames[$i], $types[$i], $sizes[$i], $errors[$i]);
            }
        // } elseif ((int) $errors !== UPLOAD_ERR_NO_FILE) {
        } else {
            self::$_files[$key] = [
                'name' => $names,
                'tempName' => $tempNames,
                'type' => $types,
                'size' => $sizes,
                'error' => $errors,
            ];
        }
    }

    private function _getFileName($fileData)
    {
        if (empty($fileData->tempName)) {
            return '';
        }
        $tempParts = explode('/', $fileData->tempName);
        $nameParts = explode('.', $fileData->name);
        $extension = array_pop($nameParts);
        $name      = implode('.', $nameParts);
        return $name . '_' . str_replace('php', '', end($tempParts)) . '.' . $extension;
    }

    public function setKeyInfo(string $key)
    {
        list($className, $id, $this->_fieldToDelete, $this->_fileToDelete) = explode('::', $key);
        list($moduleName, $model) = explode(':', $className);
        $className = 'app\modules\Codnitive\\' . $moduleName . '\models\\' . str_replace('_', '\\', $model);
        $model = new $className;
        $this->_model = $model->loadOne($id);
        return $this;
    }

    public function deleteFile(/*$file*/)
    {
        $this->_init();
        // list($dir, $file) = explode('::', $key);
        // $path = $this->_getPath() . $file;
        $this->_deleteFileFromDatabase();
        $path = $this->_getPath() . $this->_fileToDelete;
        if (file_exists($path)) {
            return unlink($path);
        }
        return true;
    }

    protected function _deleteFileFromDatabase()
    {
        $field = $this->_fieldToDelete;
        $files = $this->_model->$field;
        foreach ($files as $key => $val) {
            if ($this->_fileToDelete == $val['name']) {
                unset($files[$key]);
            }
        }
        // $this->_model->$field = serialize($files);
        // $this->_model->setAttribute($field, serialize($files));
        $this->_model->setAttribute($field, Json::encode($files));
        return $this->_model->update(true, [$field]);
    }

    public function getUploadDir()
    {
        $path = $this->_getPath();
        // if (isset($this->_settings['type'])) {
        //     $path .= $this->_settings['type'] . '/';
        // }
        if (isset($this->_settings['sub_dir'])) {
            $path .= $this->_settings['sub_dir'] . '/';
        }
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        return $path;
    }
}
