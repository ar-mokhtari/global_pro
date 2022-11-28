<?php 
return \array_merge(
    $config['modules'], 
    [
        'v1' => [
            'basePath' => '@app/modules/api',
            'class' => 'app\modules\api\v1\Module',
        ],
    ]
);
