<?php
/**
 * @NOTICE: the order of url manager files is important and must be load and merge
 * with this order
 */
// // $cmsPages      = require __DIR__ . '/url_manager/index.php';
// $cmsPages         = require __DIR__ . '/url_manager/cms_pages.php';
// $userRoutes       = require __DIR__ . '/url_manager/user_routes.php';
// $accountRoutesMap = require __DIR__ . '/url_manager/account_routes_map.php';
// $adminRoutesMap   = require __DIR__ . '/url_manager/admin_routes_map.php';
// $generalRoutes    = require __DIR__ . '/url_manager/general_routes.php';

use yii\web\UrlNormalizer;

$allRules = array_merge(
    require __DIR__ . '/url_manager/cms_pages.php',
    require __DIR__ . '/url_manager/user_routes.php',
    require __DIR__ . '/url_manager/account_routes_map.php',
    require __DIR__ . '/url_manager/admin_routes_map.php',
    require __DIR__ . '/url_manager/central_routes.php',
    require __DIR__ . '/url_manager/officeautomation_routes.php',
    require __DIR__ . '/url_manager/accounting_routes.php',
    require __DIR__ . '/url_manager/general_routes.php'
);

$config['components']['urlManager'] = [
    'class' => 'yii\web\UrlManager',
    // Disable index.php
    'showScriptName' => false,
    // Disable r= routes
    'enablePrettyUrl' => true,
    'enableStrictParsing' => false,
    // 'suffix' => '.html',
    /*'rules' => [
            // '<eventName:[0-9a-zA-Z\-]+>/e-<id:\d+>/' => 'event/index/view',
            'account/<action:\w+>' => 'account/index/<action>',
            // 'account/<action:\w+>' => 'account/index/<action>',
            'search/<module:\w+>' => '<module>/search/index',
            'search/result/<module:\w+>' => '<module>/search/result',
            'checkout/cart/add/id/<id:\d+>' => 'checkout/cart/add',
            'checkout/cart/remove/id/<id:\d+>' => 'checkout/cart/remove',
            '<controller:\w+>' => '<controller>/index',
            '<controller:\w+>/<id:\d+>' => '<controller>/view',
            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    ],*/
    'normalizer' => [
        'class' => 'yii\web\UrlNormalizer',
        // use temporary redirection instead of permanent for debugging
        'action' => UrlNormalizer::ACTION_REDIRECT_TEMPORARY,
    ],
    'rules' => array_merge([
            // [
            //     'pattern' => 'debug/default/toolbar',
            //     'route' => 'debug/default/toolbar'
            // ],
            // [
            //     'pattern' => '<lang:\w{2}>/<eventName:[0-9a-zA-Z\-]+>/e-<id:\d+>/',
            //     'route' => 'event/index/view',
            //     'defaults' => ['lang' => 'def'],
            // ],
            [
                'pattern' => '<lang:\w{2}>',
                'route' => '',
                'defaults' => ['lang' => 'def'],
                'normalizer' => [
                    // do not collapse consecutive slashes for this rule
                    'collapseSlashes' => false,
                ],
            ],
            // [
            //     'pattern' => '<lang:\w{2}>/account/<action:\w+>',
            //     'route' => 'account/index/<action>',
            //     'defaults' => ['lang' => 'def'],
            // ],
            // [
            //     'pattern' => '<lang:\w{2}>/search/<module:\w+>',
            //     'route' => '<module>/search/index',
            //     'defaults' => ['lang' => 'def'],
            // ],
            // [
            //     'pattern' => '<lang:\w{2}>/search/result/<module:\w+>',
            //     'route' => '<module>/search/result',
            //     'defaults' => ['lang' => 'def'],
            // ],
            // [
            //     'pattern' => '<lang:\w{2}>/checkout/cart/add/id/<id:\d+>',
            //     'route' => 'checkout/cart/add',
            //     'defaults' => ['lang' => 'def'],
            // ],
            // [
            //     'pattern' => '<lang:\w{2}>/checkout/cart/remove/id/<id:\d+>',
            //     'route' => 'checkout/cart/remove',
            //     'defaults' => ['lang' => 'def'],
            // ],
            // [
            //     'pattern' => '<lang:\w{2}>/<controller:\w+>',
            //     'route' => '<controller>/index',
            //     'defaults' => ['lang' => 'def'],
            // ],
            // [
            //     'pattern' => '<lang:\w{2}>/<controller:\w+>/<id:\d+>',
            //     'route' => '<controller>/view',
            //     'defaults' => ['lang' => 'def'],
            // ],
            // [
            //     'pattern' => '<lang:\w{2}>/<controller:\w+>/<action:\w+>/<id:\d+>',
            //     'route' => '<controller>/<action>',
            //     'defaults' => ['lang' => 'def'],
            // ],
            // [
            //     'pattern' => '<lang:\w{2}>/<controller:\w+>/<action:\w+>',
            //     'route' => '<controller>/<action>',
            //     'defaults' => ['lang' => 'def'],
            // ],
        ],
        // $cmsPages, 
        // $userRoutes,
        // $accountRoutesMap,
        // $generalRoutes,
        // $adminRoutesMap
        $allRules
    ),
];
