<?php

namespace app\modules\Codnitive\Accounting\core\blocks;

use app\modules\Codnitive\Core\helpers\Html;
use app\modules\Codnitive\Accounting\core\helpers\AccountingHtml;

class Template extends \app\modules\Codnitive\Core\blocks\Template
{
    protected $_html;

    public function AccountingHtml(): Html
    {
        $this->_html = new AccountingHtml;
        return $this->_html;
    }
}
