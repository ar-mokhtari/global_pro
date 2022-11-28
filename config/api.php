<?php
 
$db     = require __DIR__ . '/db.php';
$config = require __DIR__ . '/web.php';
$components = $config['components'];

// @link https://www.yiiframework.com/doc/guide/2.0/en/rest-quick-start#enabling-json-input

/**
 * customize request to accept body json data
 */
$components['request'] = array_merge(
    $components['request'], 
    [
        // diable CSRF for request, as rest is stateless and there is no cookie available
        'enableCsrfValidation' => false,
        'enableCsrfCookie' => false,
        'enableCookieValidation' => false,
        'csrfParam' => '',
        'parsers' => [
            'application/json' => 'yii\web\JsonParser',
        ]
    ]
);

/**
 * @link https://www.yiiframework.com/doc/guide/2.0/en/rest-error-handling
 * customize response data
 * 
 */
$components['response'] = [
    'class' => 'yii\web\Response',
    'format' => \yii\web\Response::FORMAT_JSON,
    'on beforeSend' => function ($event) {
        $response = $event->sender;
        // $response->data = \yii\helpers\ArrayHelper::merge(
        //     ['success' => $response->isSuccessful], 
        //     $response->data
        // );
        if (intval(\Yii::$app->request->get('suppress_response_code'))) {
            $response->statusCode = 200;
        }
        
        if (null !== $response->data && intval(\Yii::$app->request->get('wrap_response_data'))) {
            $response->data = [
                'success' => $response->isSuccessful,
                'data' => $response->data,
            ];
        }
    },
];

/**
 * define custome log file for API
 */
$components['log']['targets'][0] = array_merge(
    $components['log']['targets'][0], 
    ['logFile' => '@app/runtime/logs/api.log']
);

/**
 * load list of all endpoint routes and their configurations
 * 
 */
$components['urlManager'] = require __DIR__ . '/api/endpoints.php';

/**
 * load all base modules in codnitive plus API modules
 */
$config['modules']        = require __DIR__ . '/api/modules.php';

/**
 * customize user component by changing identity class, disable auto login, 
 * session and removing login url
 */
$user = $components['user'];
// $user['class'] = 'app\modules\api\v1\User\repositories\User'; 
$user['identityClass'] = 'app\modules\api\v1\User\repositories\User'; 
$user['enableAutoLogin'] = false; 
$user['enableSession'] = false; 
$user['loginUrl'] = null; 

/**
 * remove unnecessary configs for API
 */
unset(
    $config['controllerNamespace'],
    $config['defaultRoute'],
    $components['magDb'], 
    $components['session'], 
    $components['cookies'], 
    $components['errorHandler'],
    $components['cart'],
    $components['view'],
    $components['reCaptcha'],
    $components['assetManager'],
    $components['request']['csrfCookie'],
    $user['loginUrl'],
    // $user['authTimeout'],
    $user['identityCookie'],
);
$components['user'] = $user;
$config['components'] = $components;

return $config;
