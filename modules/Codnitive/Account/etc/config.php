<?php

return [
    'components' => [
        // list of component configurations
        'translations' => [
            'class' => \yii\i18n\PhpMessageSource::className(),
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/Codnitive/Account/i18n',
            'fileMap' => [
                'account' => 'translate.php',
            ],
        ]
    ],
    'params' => [
        // list of parameters
    ],
];
