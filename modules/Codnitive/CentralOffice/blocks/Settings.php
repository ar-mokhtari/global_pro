<?php 

namespace app\modules\Codnitive\centraloffice\blocks;

class Settings extends \app\modules\Codnitive\Core\blocks\Template
{
    public function getProfileAction()
    {
        return tools()->stripEscapeRequest(app()->getRequest())->get('action', 'profile');
    }
}
