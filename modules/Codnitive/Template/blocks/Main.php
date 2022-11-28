<?php 

namespace app\modules\Codnitive\Template\blocks;

class Main extends \app\modules\Codnitive\Core\blocks\Template
{
    public function getLanguage(): string
    {
        return tools()->getLang();
    }
}
