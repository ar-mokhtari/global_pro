<?php

return [
    [
        'pattern' => '<lang:\w{2}>/admin/<module:\w+>/<action:\w+>/<id:\d+>',
        'route' => '<module>/admin/<action>',
        'defaults' => ['lang' => 'def'],
    ],
    [
        'pattern' => '<lang:\w{2}>/admin/<module:\w+>/ajax/<action:\w+>',
        'route' => '<module>/adminajax/<action>',
        'defaults' => ['lang' => 'def'],
    ],
    [
        'pattern' => '<lang:\w{2}>/admin/<module:\w+>/<action:\w+>',
        'route' => '<module>/admin/<action>',
        'defaults' => ['lang' => 'def'],
    ],
    [
        'pattern' => '<lang:\w{2}>/admin/<action:\w+>',
        'route' => 'admin/admin/<action>',
        'defaults' => ['lang' => 'def'],
    ],
];
