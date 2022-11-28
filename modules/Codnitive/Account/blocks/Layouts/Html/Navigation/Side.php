<?php 

namespace app\modules\Codnitive\Account\blocks\Layouts\Html\Navigation;

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
        'orders' => [
            'title' => 'Orders',
            'route' => 'account/sales/list',
            'icon'  => 'fa fa-shopping-cart'
        ],
        'wallet' => [
            'title' => 'Wallet',
            'route' => 'account/wallet',
            'icon'  => 'fas fa-wallet'
        ],
        'passengers' => [
            'title' => 'Passenger Book',
            'route' => 'account/passengerbook',
            'icon'  => 'fas fa-address-book'
        ],
        // 'refund' => [
        //     'title' => 'Refund',
        //     'route' => 'account/refund',
        //     'icon'  => 'fas fa-ticket-alt'
        // ],
    ];

    public function __construct()
    {
        if (tools()->isAgent()) {
            $this->_menus['agent_flight'] = [
                'title' => 'Agent Flight Panel',
                'route' => 'account/agentpanel/flightPanel',
                'icon'  => 'fas fa-plane'
            ]; 
        }
    }

    public function getMenus()
    {
        return $this->_menus;
    }
}
