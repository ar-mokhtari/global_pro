<?php

return [
    [
        'pattern' => '<lang:\w{2}>/account/<module:\w+>/ajax/<action:\w+>',
        'route' => '<module>/accountajax/<action>',
        'defaults' => ['lang' => 'def'],
    ],
    [
        'pattern' => '<lang:\w{2}>/account/<module:\w+>/<action:\w+>',
        'route' => '<module>/account/<action>',
        'defaults' => ['lang' => 'def'],
    ],
    [
        'pattern' => '<lang:\w{2}>/account/<module:\w+>',
        'route' => '<module>/account/index',
        'defaults' => ['lang' => 'def'],
    ],
];
