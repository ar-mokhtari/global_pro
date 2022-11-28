<?php

namespace app\modules\Codnitive\Sales\models\Account\Order\MyOrder\Grid;

// use yii\db\ActiveQuery;
use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Calendar\models\Persian;

class Filter extends Order
{
    /**
     * Requried to use in filters
     */
    use \app\modules\Codnitive\Core\models\Grid\FilterTrait;

    protected $_searchParams = [];

    public function rules()
    {
        $rules = [
            [['order_number', 'fullname', 'email', 'status_label', 
                'grand_total', 'order_date', 'payment_method', 'ticket_type'
            ], 'safe'],
        ];
        return $rules;
    }

    // /**
    //  * The general filter collection is available on trait, but you can override 
    //  * it in case you need custom filter
    //  * 
    //  */
    // protected function _filterCollection(ActiveQuery $allModels): array
    // {
    //     $collection = $allModels->all();
    //     $collection = array_filter($collection, function ($object) {
    //         $conditions = [true];
    //         foreach ($this->_searchParams as $param => $searchValue) {
    //             if (!empty($searchValue)) {
    //                 $conditions[] = strpos($this->_getObjectFormattedParam($param, $object->$param), $searchValue) !== false;
    //             }
    //         }
    //         return array_product($conditions);
    //     });
    //     return $collection;
    // }

    private function _getObjectFormattedParam($param, $paramValue, $model)
    {
        $formattedValue = $paramValue;
        switch ($param) {
            case 'payment_method':
                app()->getModule(strtolower($paramValue));
                $formattedValue = getObject("app\modules\Codnitive\\$paramValue\models\Gateway")->getTitle();
                break;
            
            case 'order_date':
                $dateParts = explode(' ', tools()->getFormattedDate($paramValue, 'Y-m-d H:i'));
                $formattedValue = str_replace('-', '/', (new Persian)->getDate($dateParts[0])) . ' ' . $dateParts[1];
                break;
            
            case 'ticket_type':
                $formattedValue = __('template', $paramValue);
                break;

        }
        return $formattedValue;
    }
}
