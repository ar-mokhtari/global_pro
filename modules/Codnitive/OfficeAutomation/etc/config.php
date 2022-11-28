<?php

return [
    'components' => [
        // list of component configurations
        'translations' => [
            'class' => \yii\i18n\PhpMessageSource::className(),
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/Codnitive/OfficeAutomation/i18n',
            'fileMap' => [
                'officeautomation'  => 'translate.php',
            ],
        ]
    ],
    'params' => [
        // list of parameters
    ],
];
