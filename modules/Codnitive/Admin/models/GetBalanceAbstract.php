<?php 

namespace app\modules\Codnitive\Admin\models;

abstract class GetBalanceAbstract
{
    protected $_module = '';
    
    public function getName(): string
    {
        return __($this->_module::MODULE_ID, $this->_module::MODULE_NAME);
    }
}
