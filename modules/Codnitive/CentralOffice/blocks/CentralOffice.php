<?php 

namespace app\modules\Codnitive\CentralOffice\blocks;

class CentralOffice extends \app\modules\Codnitive\Core\blocks\Template
{
    public function getLanguage(): string
    {
        return tools()->getLang();
    }
}
