<?php

// override template
// $config['components']['view'] = [
//         'theme' => [
//             'pathMap' => [
//                 '@dektrium/user/views' => '@app/modules/Codnitive/User/views'
//             ],
//         ],
// ];
$config['modules'] = [
    'user' => [
        'class' => 'dektrium\user\Module',
    ],
];
