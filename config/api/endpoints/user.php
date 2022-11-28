<?php

return [
    [
        /**
         * yii\rest\UrlRule will generate this routes by default:
         * 
         * [
         *     'PUT,PATCH users/<id>' => 'user/update',
         *     'DELETE users/<id>' => 'user/delete',
         *     'GET,HEAD users/<id>' => 'user/view',
         *     'POST users' => 'user/create',
         *     'GET,HEAD users' => 'user/index',
         *     'users/<id>' => 'user/options',
         *     'users' => 'user/options',
         * ]
         */
        'class' => 'yii\rest\UrlRule', 

        /**
         * define default patterns for user to remove {id}
         */
        'patterns' => [
            'GET,HEAD' => 'view',
            'PATCH' => 'update',
            'POST' => 'create',
        ],

        'pluralize' => false,

        /**
         * to map custom endpoint to controller:
         * 'controller' => ['v1/u' => 'v1/user']
         */
        'controller' => ['v1/user'],
        
        /**
         * You may also configure patterns or extraPatterns to redefine existing 
         * patterns or add new patterns supported by this rule. For example, 
         * to support a new action search by the endpoint GET /users/search, 
         * configure the extraPatterns option as follows,
         * 
         */
        // 'patterns' => [
        //     'PUT,PATCH {id}' => 'update', 
        //     'DELETE {id}' => 'delete', 
        //     'GET,HEAD {id}' => 'view', 
        //     // 'GET,HEAD <id:\d+>' => 'view', 
        //     'POST' => 'create', 
        //     'GET,HEAD' => 'index', 
        //     '{id}' => 'options', 
        //     '' => 'options'
        // ],
        'extraPatterns' => [
            'POST auth' => 'auth',
            'GET,HEAD auth/token' => 'token',
            'PUT,POST passwd' => 'passwd'
        ],

        /**
         * @link https://www.yiiframework.com/doc/api/2.0/yii-rest-urlrule#$tokens-detail
         * List of tokens that should be replaced for each pattern. 
         * The keys are the token names, and the values are the corresponding replacements.
         * 
         */
        'tokens' => [
            // '{id}' => '<id:\w+>'
        ],

        // @link https://www.yiiframework.com/doc/guide/2.0/en/rest-routing
        'only' => ['view', 'create', 'update', 'auth', 'passwd', 'token'], // @todo customize rutes to work with token not id
        // 'except' => ['delete', 'options', 'view'],

        /**
         * @link https://www.yiiframework.com/doc/guide/2.0/en/rest-routing#extra-configuration-for-contained-rules
         * It could be useful to specify extra configuration that is applied to 
         * each rule contained within yii\rest\UrlRule. A good example would be 
         * specifying defaults for expand parameter
         * 
         */
        // 'ruleConfig' => [
        //     'class' => 'yii\web\UrlRule',
        //     'defaults' => [
        //         'expand' => 'credit',
        //     ]
        // ],
    ]
];
