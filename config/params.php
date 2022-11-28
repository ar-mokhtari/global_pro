<?php

return [
    'secret_key' => '',
    'adminEmail' => 'admin@gp.com',
    'cache' => [
        // @todo change to default values for porduction
        'enable' => true, // production default: true
        'flush'  => false // production default: false
    ],
    'modules' => [
        'products' => [
            100 => 'centraloffice',
        ],
        'vendors' => [
        ],
        'payments' => [],
        'providers' => [
            'template' => ['centraloffice'],
        ]
    ],
    'modulesPath' => 'C:/xampp/htdocs/GlobalPro/modules/Codnitive/',
    'whitelistIPs' => [
        '127.0.0.1',
        '192.168.1.121',
        '::1',
    ],// @TODO comment on production
    'firstDay' => '',
    'lastDay' => '',
];
