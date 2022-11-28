<?php

namespace app\modules\Codnitive\Admin\models\Orders\Grid;

use app\modules\Codnitive\Admin\models\Orders\Grid;

class Dashboard extends Grid
{
    protected $_removePager = true;
    protected $_searchModel = '';
    
    public function __construct()
    {
        parent::__construct();
        $this->_sortAttributes = [];
    }

    protected function _prepareDataCollection($columns = [])
    {
        $collection = $this->_modelObject->setOrderBy(['id' => SORT_DESC]);
        if ($this->_limit) {
            $collection->setLimit($this->_limit);
        }
        return $collection->prepareCollection($columns);
    }
}
