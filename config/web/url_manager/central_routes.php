<?php

return [
    [
        'pattern' => '<lang:\w{2}>/centraloffice',
        'route' => 'centraloffice/central/site',
        'defaults' => ['lang' => 'def'],
    ],
    [
        'pattern' => '<lang:\w{2}>/<module:\w+>/<controller:\w+>/<action:\w+>-ajax',
        'route' => '<module>/<controller>/<action>',
        'defaults' => ['lang' => 'def'],
    ],
];
