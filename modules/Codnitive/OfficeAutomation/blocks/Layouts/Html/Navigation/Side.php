<?php 

namespace app\modules\Codnitive\OfficeAutomation\blocks\Layouts\Html\Navigation;

class Side extends \app\modules\Codnitive\Core\blocks\Template
{
    protected $_menus = [
        'dashboard' => [
            'title' => 'Dashboard',
            'route' => 'account',
            'icon'  => 'fas fa-tachometer-alt'
        ],
        'profile' => [
            'title' => 'Profile',
            'route' => 'account/user/settings',
            'icon'  => 'fa fa-user',
            'params' => ['action' => 'profile']
        ],
    ];

    public function getMenus()
    {
        return $this->_menus;
    }
}
