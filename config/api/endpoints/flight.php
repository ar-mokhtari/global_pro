<?php

return [
    [
        'class' => 'yii\rest\UrlRule', 

        // 'pluralize' => false,

        'controller' => ['v1/flight'],
        
        /**
         * You may also configure patterns or extraPatterns to redefine existing 
         * patterns or add new patterns supported by this rule. For example, 
         * to support a new action search by the endpoint GET /users/search, 
         * configure the extraPatterns option as follows,
         * 
         */
        'patterns' => [
            'PATCH {orderId}' => 'book', 
        //     'DELETE {id}' => 'delete', 
            'GET,HEAD {uniqueId}' => 'view', 
        //     // 'GET,HEAD <id:\d+>' => 'view', 
            'POST {uniqueId}/{paymentMethod}' => 'order', 
            'POST' => 'index', 
        //     '{id}' => 'options', 
        //     '' => 'options'
        ],
        'extraPatterns' => [
            'GET,HEAD {scope}/airports' => 'airport',
            'GET,HEAD {scope}/airports/{query}' => 'airportFind',
            // 'GET,HEAD classes' => 'cabinClass',
            // 'POST,PUT passengers' => 'passenger',
            'GET,HEAD sources/{source}' => 'source',
        ],

        /**
         * @link https://www.yiiframework.com/doc/api/2.0/yii-rest-urlrule#$tokens-detail
         * List of tokens that should be replaced for each pattern. 
         * The keys are the token names, and the values are the corresponding replacements.
         * 
         */
        'tokens' => [
            '{uniqueId}' => '<uniqueId:\d+:[0-9a-zA-Z]+>',
            '{scope}' => '<scope:intl|domc>',
            '{query}' => '<query:\w+>',
            '{paymentMethod}' => '<paymentMethod:\w+>',
            '{source}' => '<source:\w+>',
            '{orderId}' => '<orderId:\d+>',
        ],

        // @link https://www.yiiframework.com/doc/guide/2.0/en/rest-routing
        // 'only' => ['view', 'create', 'update', 'auth', 'passwd'], // @todo customize rutes to work with token not id
        // 'except' => ['delete', 'options', 'index'],

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
