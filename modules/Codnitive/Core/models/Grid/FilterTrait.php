<?php

namespace app\modules\Codnitive\Core\models\Grid;

use yii\db\ActiveQuery;

trait FilterTrait
{
    protected $_searchParams = [];

    /**
     * setup search function for filtering and sorting 
     * based on `orderAmount` field
     */
    public function search(array $params, ActiveQuery $allModels): array
    {
        $this->_searchParams = $params;
        $collection = $this->_filterCollection($allModels);

        foreach ($collection as &$object) {
            $data = $this->jsonDecodeFields($object);
            $object->setAttributes($data);
        }
        return $collection;
    }

    // protected function _filterCollection(ActiveQuery $allModels): array
    // {
    //     $collection = $allModels->all();

    //     $collection = array_filter($collection, function ($object) {
    //         $conditions = [true];
    //         foreach ($this->_searchParams as $param => $value) {
    //             if (!empty($value)) {
    //                 $conditions[] = strpos($object->$param, $value) !== false;
    //             }
    //         }
    //         return array_product($conditions);
    //     });
    //     return $collection;
    // }

    /**
     * The general filter collection is available on trait, but you can override 
     * it in case you need custom filter
     * 
     */
    protected function _filterCollection(ActiveQuery $allModels): array
    {
        $collection = $allModels->all();
        $collection = array_filter($collection, function ($object) {
            $conditions = [true];
            foreach ($this->_searchParams as $param => $searchValue) {
                if (!empty($searchValue)) {
                    $conditions[] = strpos(
                        strtolower($this->_getObjectFormattedParam($param, $object->$param, $object)), 
                        strtolower($searchValue)
                    ) !== false;
                }
            }
            return array_product($conditions);
        });
        return $collection;
    }

    protected function _getObjectFormattedParam($param, $paramValue, $model)
    {
        return $paramValue;

        // $formattedValue = $paramValue;
        // switch ($param) {
        //     case 'trasaction_date':
        //         $dateParts = explode(' ', tools()->getFormattedDate($paramValue, 'Y-m-d H:i'));
        //         $formattedValue = str_replace('-', '/', (new Persian)->getDate($dateParts[0])) . ' ' . $dateParts[1];
        //         break;

        // }
        // return $formattedValue;
    }
}
