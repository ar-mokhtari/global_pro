<?php 

namespace app\modules\Codnitive\Accounting\blocks;

class Accounting extends \app\modules\Codnitive\Core\blocks\Template
{
    public function getLanguage(): string
    {
        return tools()->getLang();
    }
}
