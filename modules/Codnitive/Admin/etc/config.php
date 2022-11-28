<?php

return [
    'components' => [
        // list of component configurations
        'translations' => [
            'class' => \yii\i18n\PhpMessageSource::className(),
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/Codnitive/Admin/i18n',
            'fileMap' => [
                \app\modules\Codnitive\Admin\Module::MODULE_ID => 'translate.php',
            ],
        ]
    ],
    'params' => [
        // list of parameters
    ],
];
