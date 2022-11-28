<?php

namespace app\modules\Codnitive\Admin\models\Orders;

use app\modules\Codnitive\Sales\models\Account\Order\MyOrder\Grid as MainGrid;

class Grid extends MainGrid
{
    protected $_modelClass      = '\app\modules\Codnitive\Admin\models\Order';
    protected $_searchModel     = '\app\modules\Codnitive\Admin\models\Orders\Grid\Filter';
    // protected $_actionsTemplate = '{view}';
    
    public function __construct()
    {
        parent::__construct();
        $this->_sortAttributes = array_merge($this->_sortAttributes, ['cellphone']);
        $this->_columns = array_merge($this->_columns, ['cellphone']);
    }

    protected function _prepareDataCollection($columns = [])
    {
        return $this->_modelObject->setOrderBy(['id' => SORT_DESC])->prepareCollection($columns);
    }

    protected function _prepareColumnsFormat()
    {
        $columns = parent::_prepareColumnsFormat();
        $cellphone = [
            'attribute' => 'cellphone',
            'contentOptions' => ['class' => 'text-center col-order-number'],
            'label' => __('template', 'Cellphone')
        ];
        return tools()->arrayInsertAfter($columns, 1, $cellphone);
    }
}
