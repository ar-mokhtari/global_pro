<?php

namespace app\modules\Codnitive\OfficeAutomation\core\blocks;

use app\modules\Codnitive\Core\helpers\Html;
use app\modules\Codnitive\OfficeAutomation\core\helpers\OfficeHtml;

class Template extends \app\modules\Codnitive\Core\blocks\Template
{
    protected $_html;

    public function OfficeHtml(): Html
    {
        $this->_html = new OfficeHtml;
        return $this->_html;
    }
}
