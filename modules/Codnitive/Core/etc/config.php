<?php

return [
    'components' => [
        // list of component configurations
        'translations' => [
            'class' => \yii\i18n\PhpMessageSource::className(),
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/Codnitive/Core/i18n',
            'fileMap' => [
                'core' => 'translate.php',
            ],
        ]
    ],
    'params' => [
        // list of parameters
    ],
];
