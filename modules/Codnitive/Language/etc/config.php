<?php

return [
    'components' => [
        // list of component configurations
        'translations' => [
            'class' => \yii\i18n\PhpMessageSource::className(),
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/Codnitive/Language/i18n',
            'fileMap' => [
                'language' => 'translate.php',
            ],
        ]
    ],
    'params' => [
        // list of parameters
    ],
];
