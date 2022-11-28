<?php

$params = require __DIR__ . '/params.php';
$db     = require __DIR__ . '/db.php';

$isLocal = in_array($_SERVER['HTTP_HOST'], ['gp.loc', '127.0.0.1','192.168.1.120']) ? true : false;
$secureCookie = !$isLocal;

$config = [
    'id' => 'basic',
    'name' => 'gp.loc',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log', // @TODO comment out on production

        // added by default to work enywhere
        // [
        //     'class' => 'app\modules\Codnitive\Language\LanguageSelector',
        //     // 'supportedLanguages' => ['en-US', 'fa-IR'],
        // ],
        'core',
        'language',
        'template',
        'account',
        'calendar',


        // extra modules to load
        // 'insurance',
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'timeZone' => 'Asia/Tehran',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '4f21d67c71cd2de279a230d7193f8ffc7ed510a5',
            'enableCsrfValidation' => true,
            'csrfCookie' => [
                'httpOnly' => true,
                'secure' => $secureCookie,
            ]
        ],
        'formatter' => [
            'class' => 'yii\i18n\formatter',
            'thousandSeparator' => ',',
            'decimalSeparator' => '.',
            'currencyCode' => ' ',
            'nullDisplay' => '',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\Codnitive\Account\models\User',
            // 'identityClass' => 'dektrium\user\models\User',
            'enableAutoLogin' => true,
            'authTimeout' => 60 * 90, // auth expire
            'loginUrl' => '/user/login',
            'identityCookie' => [
                'name' => '_identity',
                'httpOnly' => true,
                'secure' => $secureCookie,
                // 'domain' => '.bilit.com',
            ],
        ],
        'session' => [
            // 'class' => 'yii\web\DbSession',
            // 'class' => 'yii\web\Session',
            // 'cookieParams' => ['httponly' => true, 'lifetime' => 3600 * 4],

            // need to install yiisoft/yii2-redis first: composer require yiisoft/yii2-redis
            // @link https://www.yiiframework.com/extension/yiisoft/yii2-redis
            // @link https://www.yiiframework.com/extension/yiisoft/yii2-redis/doc/api/2.0/yii-redis-session
            'class' => 'yii\redis\Session',
            // config redis as a connection
            // @link https://www.yiiframework.com/extension/yiisoft/yii2-redis/doc/api/2.0/yii-redis-connection
            'redis' => [
                // 'hostname' => 'localhost',
                // 'port' => 6379,
//                'unixSocket' => '/var/run/redis/redis.sock',
                'database' => 0
            ],

            'timeout' => 60 * 90, //session expire
            // 'useCookies' => true,
            'cookieParams' => [
                'httpOnly' => true,
                'secure' => $secureCookie,
            ]
        ],
        'cookies' => [
            'class' => 'yii\web\Cookie',
            'httpOnly' => true,
            'secure' => $secureCookie,
        ],

        // @link https://www.yiiframework.com/doc/guide/2.0/en/caching-data
        // @link https://www.yiiframework.com/doc/guide/2.0/en/tutorial-performance-tuning
        // @link https://www.yiiframework.com/doc/guide/2.0/en/caching-http
        // @link https://www.yiiframework.com/doc/guide/2.0/en/caching-fragment
        // @link https://www.yiiframework.com/doc/guide/2.0/en/caching-page

        // for monolotic apps apcu is faster than redis for page and data caching
        // @link https://www.yiiframework.com/doc/guide/2.0/en/caching-data#supported-cache-storage
        // @link https://forum.yiiframework.com/t/which-cache-storage-for-page-and-fragment-caching/86286
        'cache' => [
            // 'class' => 'yii\caching\FileCache',
            // 'class' => 'yii\caching\ApcCache',
            // 'useApcu' => true,

            // need to install yiisoft/yii2-redis first: composer require yiisoft/yii2-redis
            // @link https://www.yiiframework.com/extension/yiisoft/yii2-redis
            // @link https://www.yiiframework.com/extension/yiisoft/yii2-redis/doc/api/2.0/yii-redis-cache
            'class' => 'yii\redis\Cache',
            'redis' => [
                // 'hostname' => 'localhost',
                // 'port' => 6379,
//                'unixSocket' => '/var/run/redis/redis.sock',
                'database' => 1
            ],

            'keyPrefix' => '',
            // change cache life time based on traffic
            'defaultDuration' => 60 * 90,
        ],
        // for production without caching modules or apps
        // 'cache' => [
        //     'class' => 'yii\caching\ArrayCache',
        //     'serializer' => false,
        //     'keyPrefix' => 'bilit.com-',
        //     // change cache life time based on traffic
        //     'defaultDuration' => 60 * 10,
        // ],
        'errorHandler' => [
            'class' => 'app\modules\Codnitive\Template\ErrorHandler',
            'errorAction' => 'template/http/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => $isLocal,
            // 'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '',//i.e the main  site on mine is mysite.org but the site that is sending emails is  mysite.com but it needs to be set to mail.mysite.org because that is the  main account on the shared hosting.
                'username' => '',//NOT an email account
                'password' => '', // old 0: '', // cpanel password
                'port' => '',//need a port
                // 'encryption' => 'tls',//must be lowercase for all encryption types or will throw cant find encryption type extension
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        /*'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            // 'suffix' => '.html',
            'rules' => [
                    '<controller:\w+>' => '<controller>/index',
                    'account/<action:\w+>' => 'account/index/<action>',
                    // 'account/<action:\w+>' => 'account/index/<action>',
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],*/
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    // 'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                    // 'sourceLanguage' => 'en-US',
                    // 'fileMap' => [
                    //     'main' => 'main.php',
                    // ],
                ],
                'user*' => [ //
                    'class' => \yii\i18n\PhpMessageSource::className(),
                    'basePath' => '@app/modules/Codnitive/Account/i18n', // my custom message path.
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'user' => 'user.php', // I put this file on folder common/messages/ms/user.php so yours zh-CN
                    ],
                ],
                'account' => [
                    'class' => \yii\i18n\PhpMessageSource::className(),
                    'sourceLanguage' => 'en-US',
                    'basePath' => '@app/modules/Codnitive/Account/i18n',
                    'fileMap' => [
                        'account' => 'translate.php',
                    ],
                ],
            ],
        ],
        // @link https://github.com/himiklab/yii2-recaptcha-widget
        'reCaptcha' => [
            'class' => 'himiklab\yii2\recaptcha\ReCaptchaConfig',
             'siteKeyV3' => 'your siteKey v3',
             'secretV3' => 'your secret key v3',
        ],
    ],
    'params' => $params,
    // 'on beforeAction' => function ($event) {
    //     \Yii::$app->language = \app\modules\Codnitive\Core\helpers\Tools::getOptionValue('Core', 'Langi18n', \Yii::$app->request->get('lang'));
    // },
];

require __DIR__ . '/web/url_manager.php';
require __DIR__ . '/web/codnitive.php';
require __DIR__ . '/web/user.php';
require __DIR__ . '/web/cart.php';

$config['modules']['gridview'] = ['class' => 'kartik\grid\Module'];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
