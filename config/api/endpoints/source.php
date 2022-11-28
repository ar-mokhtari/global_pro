<?php

return [
    [
        'class' => 'yii\rest\UrlRule', 

        // 'pluralize' => false,

        'controller' => ['v1/source'],
        
        /**
         * You may also configure patterns or extraPatterns to redefine existing 
         * patterns or add new patterns supported by this rule. For example, 
         * to support a new action search by the endpoint GET /users/search, 
         * configure the extraPatterns option as follows,
         * 
         */
        'patterns' => [
            'GET,HEAD {source}' => 'view'
        ],

        /**
         * @link https://www.yiiframework.com/doc/api/2.0/yii-rest-urlrule#$tokens-detail
         * List of tokens that should be replaced for each pattern. 
         * The keys are the token names, and the values are the corresponding replacements.
         * 
         */
        'tokens' => [
            '{source}' => '<source:\w+>',
        ],
    ]
];
