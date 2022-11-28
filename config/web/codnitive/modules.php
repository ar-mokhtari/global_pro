<?php

$config['modules'] = [
    'core' => [
        'class' => 'app\modules\Codnitive\Core\Module',
    ],
    'language' => [
        'class' => 'app\modules\Codnitive\Language\Module',
    ],
    'template' => [
        'class' => 'app\modules\Codnitive\Template\Module',
    ],
    'account' => [
        'class' => 'app\modules\Codnitive\Account\Module',
        /*'controllerMap' => [
            'dashboard' => 'app\modules\Codnitive\Account\controllers\DashboardController',
        ]*/
    ],
    'admin' => [
        'class' => 'app\modules\Codnitive\Admin\Module',
    ],
    'calendar' => [
        'class' => 'app\modules\Codnitive\Calendar\Module',
    ],
    'cms' => [
        'class' => 'app\modules\Codnitive\Cms\Module',
    ],
    'setup' => [
        'class' => 'app\modules\Codnitive\Setup\Module',
    ],
    'officeautomation' => [
        'class' => 'app\modules\Codnitive\OfficeAutomation\Module',
    ],
    'accounting' => [
        'class' => 'app\modules\Codnitive\Accounting\Module',
    ],
    'centraloffice' => [
        'class' => 'app\modules\Codnitive\CentralOffice\Module',
    ],
];
