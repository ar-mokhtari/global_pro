<?php

namespace app\modules\Codnitive\Account\models\Sales\Order\MyOrder;

use app\modules\Codnitive\Sales\models\Account\Order\MyOrder\Grid as SalesOrderGrid;

class Grid extends SalesOrderGrid
{
    protected $_removePager = true;
    protected $_searchModel = '';
    
    public function __construct()
    {
        parent::__construct();
        $this->_sortAttributes = [];
    }
}
