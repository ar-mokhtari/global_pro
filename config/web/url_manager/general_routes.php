<?php

return [
    [
        'pattern' => '<lang:\w{2}>/<module:\w+>/<controller:\w+>/<action:\w+>',
        'route' => '<module>/<controller>/<action>',
        'defaults' => ['lang' => 'def'],
    ],
        [
        'pattern' => '<lang:\w{2}>/<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>',
        'route' => '<module>/<controller>/<action>',
        'defaults' => ['lang' => 'def'],
    ],
    [
        'pattern' => '<lang:\w{2}>/<module:\w+>/<controller:\w+>',
        'route' => '<module>/<controller>/index',
        'defaults' => ['lang' => 'def'],
    ],
    [
        'pattern' => '<lang:\w{2}>/<module:\w+>',
        'route' => '<module>/index/index',
        'defaults' => ['lang' => 'def'],
    ],
];
