<?php

// override template
$config['controllerNamespace'] = 'modules\\Codnitive\\Template\\controllers';
$config['defaultRoute'] = 'template/index';
// remove Yii default bootstrab css
$config['components']['assetManager'] = [
    // @TODO comment out on production to make assets caching enabled
    // 'appendTimestamp' => true,
    'bundles' => [
        'yii\bootstrap\BootstrapAsset' => [
            // 'sourcePath' => null,   // do not publish the bundle
            // 'js' => [
            //     '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
            // ]
            'css' => []
        ],
    ],
    /**
     * forceCopy true makes assets caching disable, remove this in production
     * @TODO remove in production
     */
    'forceCopy' => true, 
];
// $config['components']['contentNegotiator'] = [
//     'class' => 'yii\filters\ContentNegotiator',
//     'languages' => ['en', 'fa'],
// ];
// $config['components']['urlManager'] = [
//     'ruleConfig' => [
//         'class' => 'app\modules\Codnitive\Language\LanguageUrlRule'
//     ],
// ];
require __DIR__ . '/codnitive/modules.php';
