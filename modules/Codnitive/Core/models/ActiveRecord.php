<?php

namespace app\modules\Codnitive\Core\models;

use Yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord as BaseActiveRecord;
// use app\modules\Codnitive\Core\helpers\Tools;
use app\modules\Codnitive\Core\blocks\Pagination;

abstract class ActiveRecord extends BaseActiveRecord
{
    const ERROR_REGISTRY_KEY = 'ActiveRecord_save_error';

    private $_collection;

    protected $_data = [];
    protected $_uploadedData = [];
    // protected $_fileFields = [];
    protected $_uploadFields = [];
    protected $_arrayFields = [];
    protected $_checkListFields = [];
    protected $_uploadSingle = [];

    // collection settings
    protected $_limit               = PHP_INT_MAX;
    protected $_offset              = 0;
    protected $_page                = 1;
    protected $_pageSize            = 10;
    protected $_pagination          = 0;
    protected $_parentObjectField   = '';
    protected $_parentObjectId      = 0;
    protected $_sortOrder           = [];
    protected $_groupBy             = [];

    protected $_andWhere            = [];

    /** @inheritdoc */
    public function __construct($data = [])
    {
        parent::__construct();
        $this->setData($data);
    }

    public function setData($data)
    {
        // $data = $this->formatData($data);
        $this->_data = $data;
        $this->setAttributes($data);
        return $this;
    }

    public function getData()
    {
        return $this->jsonDecodeFields($this->getAttributes());   
    }

    public function setParentObjectId($fieldName, $id)
    {
        $this->_parentObjectField = $fieldName;
        $this->_parentObjectId = $id;
        return $this;
    }

    public function setOrderBy($sortOrder)
    {
        $this->_sortOrder = $sortOrder;
        return $this;
    }

    public function setGroupBy($groupBy)
    {
        $this->_groupBy = $groupBy;
        return $this;
    }

    public function setLimit($limit)
    {
        $this->_limit = $limit;
        return $this;
    }

    public function setOffset($offset)
    {
        $this->_offset = $offset;
        return $this;
    }

    public function setPage($page)
    {
        $this->_page = $page;
        return $this;
    }

    public function getPage()
    {
        return $this->_page;
    }

    public function setPageSize($size)
    {
        $this->_pageSize = $size;
        return $this;
    }

    public function getPageSize()
    {
        return $this->_pageSize;
    }

    public function getOffset()
    {
        // $this->_offset = $this->_limit * ($this->_page - 1);
        return $this->_offset;
    }

    public function removeCollectionLimit()
    {
        $this->_limit = PHP_INT_MAX;
        return $this;
    }

    public function formatData($data)
    {
        foreach ($this->_checkListFields as $field) {
            if (isset($data[$field]) && is_array($data[$field])) {
                $arrayData = reset($data[$field]);
                if (is_array($arrayData)) {
                    $data[$field] = $arrayData;
                }
            }
        }
        return $data;
    }

    public function getUploadFields()
    {
        return $this->_uploadFields;
    }

    // public function beforeSave($insert)
    // {
    //     if (!parent::beforeSave($insert)) {
    //         return false;
    //     }
    //
    //     echo '<pre>';
    //     $data = $this->attributes;
    //     unset($data['images']);
    //     // $this->attributes = $data;
    //     $this->setAttributes($data);
    //     // print_r($this->getAttributes());
    //     // exit;
    //     return true;
    // }

    // public function saveData()
    public function save($runValidation = true, $attributeNames = null)
    {
        $data = $this->formatData($this->getAttributes());
        $this->setData($data);
        if ($result = $this->validate()) {
            $this->mapUploadedData()
                ->jsonEncodeFields();
                // ->serializeFields();
            $this->setAttributes($this->_data);
            $result = parent::save($runValidation, $attributeNames);
        }
        if (!$result) {
            $this->_registerError();
        }
        return $result;
    }

    public function loadOne(int $id, array $where = [])
    {
        if (empty($where)) {
            $where = ['id' => $id];
        }
        $object = $this->find()->where($where)->limit(1)->one();
        if (!$object) {
            return new $this;
        }
        // $data = $this->unserializeFields($data);
        return $this->jsonDecodeFields($object);
        // return $data;
    }

    public function setUploadedData($uploadedData)
    {
        $this->_uploadedData = $uploadedData;
        return $this;
    }

    public function mapUploadedData()
    {
        $uploadedData = $this->_uploadedData;
        if (is_array($uploadedData) && !empty($uploadedData)) {
            foreach ($uploadedData as $field => $data) {
                if (isset($this->oldAttributes[$field])) {
                    // $oldData = unserialize($this->oldAttributes[$field]);
                    $oldData = Json::decode($this->oldAttributes[$field]);
                    if (!empty($oldData)) {
                        if (in_array($field, $this->_uploadSingle)) {
                            reset($data);
                            $data = (isset($data[0]['save']) && $data[0]['save'])
                                    ? $data
                                    : $oldData;
                        }
                        else {
                            $data = ArrayHelper::merge($oldData, $data);
                        }
                    }
                }
                $this->_data[$field] = !empty($data) ? $data : '';
            }
        }

        $this->setData($this->_data);
        return $this;
    }

    public function getErrorsMessage()
    {
        $html = '<ul class="errors-message">';
        foreach ($this->getErrors() as $errors) {
            foreach ($errors as $error) {
                $html .= "<li>$error</li>";
            }
        }
        return $html .= '</ul>';
    }

    // public function serializeFields()
    public function jsonEncodeFields()
    {
        foreach ($this->_arrayFields as $field) {
            if (!empty($this->_data[$field])) {
                // $this->_data->$field = serialize($this->_data->$field);
                // $this->_data[$field] = serialize($this->_data[$field]);
                $this->_data[$field] = Json::encode($this->_data[$field]);
            }
        }
        return $this;
    }

    // public function unserializeFields($data)
    public function jsonDecodeFields($data)
    {
        foreach ($this->_arrayFields as $field) {
            if (isset($data->$field) && !empty($data->$field) && !is_array($data->$field)) {
                // $data->$field = unserialize($data->$field);
                $data->$field = Json::decode($data->$field);
            }
            else if (isset($data[$field]) && !empty($data[$field]) && !is_array($data[$field])) {
                // $data->$field = unserialize($data->$field);
                $data[$field] = Json::decode($data[$field]);
            }
        }
        return $data;
    }

    public function convertFormArrayToModelArray($dataArray, $uploaded = [])
    {
        $data = [];

        // array_unshift($uploaded['images'], "");
        // unset($uploaded['images'][0]);

        $dataArray = array_merge($dataArray, $uploaded);
        foreach ($dataArray as $field => $values) {
            if (is_array($values)) {
                // $values = array_values($values);
                foreach ($values as $key => $value) {
                    $data[$key][$field] = in_array($field, $this->_uploadFields) ? [$value] : $value;
                }
            }
        }
        return $data;
    }

    public function andWhere($condition)
    {
        $this->_andWhere = $condition;
        return $this;
    }

    protected function _prepareCollection($fieldsToSelect = ['*'])
    {
        $collection = $this->find()
            ->select($fieldsToSelect)
            ->limit($this->_limit)
            ->offset($this->getOffset());
        if (!empty($this->_parentObjectId)) {
            $collection->where([$this->_parentObjectField => $this->_parentObjectId]);
        }
        if (!empty($this->_sortOrder)) {
            $collection->orderBy($this->_sortOrder);
        }
        if (!empty($this->_groupBy)) {
            $collection->groupBy($this->_groupBy);
        }
        if (!empty($this->_andWhere)) {
            $collection->andWhere($this->_andWhere);
        }
        return $collection;
    }

    public function prepareCollection($fieldsToSelect = ['*'])
    {
        return $this->_prepareCollection($fieldsToSelect);
    }

    public function getCollection($fieldsToSelect = ['*'], bool $asArray = false, string $arrayKeyField = 'id')
    {
        $this->_collection = $this->_prepareCollection($fieldsToSelect);
        if ($this->getPagination()) {
            $this->setCollecationPage();
        }

        if ($asArray) {
            $this->_collection->asArray();
        }
        $collection = $this->_collection->all();
        if ($asArray) {
            // $collection = array_combine(array_column($collection, $arrayKeyField), $collection);
            $collection = tools()->arraySetFieldAsKey($collection, $arrayKeyField);
            foreach ($collection as $key => $item) {
                $collection[$key] = $this->jsonDecodeFields($item);
            }
        }
        else {
            foreach ($collection as &$object) {
                $data = $this->jsonDecodeFields($object);
                $object->setAttributes($data);
            }
        }
        return $collection;
    }

    public function countCollection()
    {
        return $this->_prepareCollection()->distinct()->count();
        // return $this->_prepareCollection()->groupBy($this->_groupBy)->count();
    }

    private function _registerError()
    {
        tools()->registerError(
            self::ERROR_REGISTRY_KEY, 
            get_class($this), 
            $this->getErrors()
        );
        return $this;
        // $session = app()->session;
        // $errors = $session->get(self::ERROR_REGISTRY_KEY);
        // $errors[get_class($this)][] = $this->getErrors();
        // $session->set(self::ERROR_REGISTRY_KEY, $errors);
        // return $this;
    }

    public function setPagination($status)
    {
        $this->_pagination = $status;
        return $this;
    }

    public function getPagination()
    {
        if (!$this->_pagination) {
            return false;
        }
        return new Pagination($this->countCollection(), $this->getPageSize());
    }

    public function setCollecationPage()
    {
        $pagination = $this->getPagination();
        $this->_collection
            ->offset($pagination->getOffset())
            ->limit($pagination->getLimit());
        return $this;
    }
}
