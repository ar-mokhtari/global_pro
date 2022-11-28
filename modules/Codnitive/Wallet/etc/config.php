<?php

return [
    'components' => [
        // list of component configurations
        'translations' => [
            'class' => \yii\i18n\PhpMessageSource::className(),
            'sourceLanguage' => 'en-US',
            'basePath' => '@app/modules/Codnitive/Wallet/i18n',
            'fileMap' => [
                \app\modules\Codnitive\Wallet\Module::MODULE_ID => 'translate.php',
            ],
        ]
    ],
    'params' => [
        // list of parameters
        'payments' => [
            // order of payment
            20 => [
                'name'           => 'Wallet',
                'icon'           => 'fa fa-wallet',
                'template'       => '@app/modules/Codnitive/Wallet/views/templates/payment/credit.form.phtml',
                // 'form'           => 'bus/ajax/searchForm',
                'form'           => '',
                'title'          => 'My Wallet',
                'visibility'     => 'registered',
            ],
        ]
    ],
];
