<?php

return [
    'components' => [
        // list of component configurations
        'translations' => [
            'class' => \yii\i18n\PhpMessageSource::className(),
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/Codnitive/Template/i18n',
            'fileMap' => [
                'template' => 'translate.php',
            ],
        ]
    ],
    'params' => [
        // list of parameters
        'defaultExtension' => 'phtml'
    ],
];
