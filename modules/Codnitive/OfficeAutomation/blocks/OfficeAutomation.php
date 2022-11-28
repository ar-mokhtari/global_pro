<?php 

namespace app\modules\Codnitive\OfficeAutomation\blocks;

class OfficeAutomation extends \app\modules\Codnitive\Core\blocks\Template
{
    public function getLanguage(): string
    {
        return tools()->getLang();
    }
}
