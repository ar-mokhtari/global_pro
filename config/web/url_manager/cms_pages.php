<?php

return [
    [
        'pattern' => '<lang:\w{2}>/about-us',
        'route' => 'cms/about/index',
        'defaults' => ['lang' => 'def'],
    ],
    [
        'pattern' => '<lang:\w{2}>/contact-us',
        'route' => 'cms/contact/index',
        'defaults' => ['lang' => 'def'],
    ],
    [
        'pattern' => '<lang:\w{2}>/terms-and-conditions',
        'route' => 'cms/terms/index',
        'defaults' => ['lang' => 'def'],
    ],
];
