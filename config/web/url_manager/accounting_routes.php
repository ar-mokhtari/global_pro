<?php

return [
    [
        'pattern' => '<lang:\w{2}>/<module:\w+>/<controller:\w+>/<action:\w+>',
        'route' => '<module>/<controller>/<action>',
        'defaults' => ['lang' => 'def'],
    ],
];
