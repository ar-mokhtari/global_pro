<?php

return [
    [
        'pattern' => '<lang:\w{2}>/account/user/<controller:\w+>',
        'route' => 'user/<controller>/account',
        'defaults' => ['lang' => 'def'],
    ],
    [
        'pattern' => '<lang:\w{2}>/user/register',
        'route' => 'user/registration/register',
        'defaults' => ['lang' => 'def'],
    ],
    [
        'pattern' => '<lang:\w{2}>/user/login',
        'route' => 'user/security/login',
        'defaults' => ['lang' => 'def'],
    ],
    [
        'pattern' => '<lang:\w{2}>/user/logout',
        'route' => 'user/security/logout',
        'defaults' => ['lang' => 'def'],
    ],
];
