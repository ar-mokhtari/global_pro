<?php

// $config['components']['user'] = [
//     'loginUrl' => [\app\modules\Codnitive\Core\helpers\Tools::getUrl('accountssdf/login')],
// ];

//override template
$config['components']['view'] = [
        'theme' => [
            'pathMap' => [
                '@dektrium/user/views' => '@app/modules/Codnitive/Account/views'
                // '@dektrium/user/views' => '@app/views/user',
            ],
        ],
];
$config['modules']['user'] = [
    'class' => 'app\modules\Codnitive\Account\Module',
    // 'class' => 'dektrium\user\Module',
    'modelMap' => [
        // 'RegistrationForm' => 'app\models\RegistrationForm',
        // 'Profile' => 'app\models\Profile',
        'User'              => 'app\modules\Codnitive\Account\models\User',
        'SettingsForm'      => 'app\modules\Codnitive\Account\models\SettingsForm',
        'LoginForm'         => 'app\modules\Codnitive\Account\models\LoginForm',
        'RegistrationForm'  => 'app\modules\Codnitive\Account\models\RegistrationForm',
        // 'RecoveryForm'      => 'app\modules\Codnitive\Account\models\RecoveryForm',
    ],
    // override controller
    'controllerMap' => [
        'admin'         => 'app\modules\Codnitive\Account\controllers\AdminController',
        'profile'       => 'app\modules\Codnitive\Account\controllers\ProfileController',
        'recovery'      => 'app\modules\Codnitive\Account\controllers\RecoveryController',
        // 'registration'  => 'app\modules\Codnitive\Account\controllers\RegistrationController',
        // 'security'      => 'app\modules\Codnitive\Account\controllers\SecurityController',
        'settings'      => [
            'class' => 'app\modules\Codnitive\Account\controllers\SettingsController',
            'on ' . \dektrium\user\controllers\SettingsController::EVENT_AFTER_ACCOUNT_UPDATE => function ($e) {
                $url = \Yii::$app->request->getUrl();
                $params = \app\modules\Codnitive\Core\helpers\Tools::getUrlStrParameters($url);
                if (!empty($e->form->fullname)) {
                    unset($params['force_redirect']);
                }
                \Yii::$app->request->setUrl(parse_url($url)['path'] . '?' . http_build_query($params));
            }
        ],
        'security'  => [
            // 'class' => \dektrium\user\controllers\RegistrationController::className(),
            'class' => 'app\modules\Codnitive\Account\controllers\SecurityController',
            'on ' . \dektrium\user\controllers\SecurityController::EVENT_BEFORE_LOGIN => function ($e) {
                if (\Yii::$app->request->get('prev_url')) {
                    \yii\helpers\Url::remember([\Yii::$app->request->get('prev_url')], 'prev_url');
                }
                // if (!preg_match('/(fa|en)/', tools()->getCurrentUrl())) {
                //     \Yii::$app->response->redirect(tools()->getUrl('user/login'));
                // }
            },
            'on ' . \dektrium\user\controllers\SecurityController::EVENT_AFTER_LOGIN => function ($e) {
                $url = \yii\helpers\Url::previous('prev_url');
                $reg = tools()->getUrl('user/register');
                $for = tools()->getUrl('user/forgot');
                if (!$url || false !== strpos($url, $reg) || false !== strpos($url, $for)) {
                    $url = tools()->getBaseUrl();
                }
                \Yii::$app->getSession()->remove('prev_url');
                \Yii::$app->response->redirect($url)->send();
                \Yii::$app->end();
                return;
                // app()->user->returnUrl = tools()->getUrl(app()->user->returnUrl);
            }
        ],
        'registration'  => [
            // 'class' => \dektrium\user\controllers\RegistrationController::className(),
            'class' => 'app\modules\Codnitive\Account\controllers\RegistrationController',
            'on ' . \dektrium\user\controllers\RegistrationController::EVENT_BEFORE_REGISTER => function ($e) {
                // if ((int) \Yii::$app->request->get('remember_cart')) {
                //     \yii\helpers\Url::remember(['/checkout/cart'], 'cart_url');
                // }
                if (\Yii::$app->request->get('prev_url')) {
                    \yii\helpers\Url::remember([\Yii::$app->request->get('prev_url')], 'prev_url');
                }
            },
            'on ' . \dektrium\user\controllers\RegistrationController::EVENT_AFTER_REGISTER => function ($e) {
                // <<< to auto login user after registreation
                $user = \dektrium\user\models\User::findOne(['username'=>$e->form->username]);
                $pass = \dektrium\user\helpers\Password::validate($e->form->password, $user->password_hash);
                if ($user && $pass) {
                    Yii::$app->user->switchIdentity($user);
                }
                // >>> to auto login

                if ($url = \yii\helpers\Url::previous('prev_url')) {
                    \Yii::$app->getSession()->remove('prev_url');
                    \Yii::$app->response->redirect($url)->send();
                }
                else {
                    \Yii::$app->response->redirect(['user/security/login'])->send();
                }
                \Yii::$app->end();
            }
        ],
    ],
    'mailer' => [
        'class' => 'app\modules\Codnitive\Account\models\Mailer',
        'sender'                => ['admin@gp.com' => 'gp Admin'], // or ['no-reply@myhost.com' => 'Sender name']
        // 'welcomeSubject'        => 'Welcome subject',
        // 'confirmationSubject'   => 'Confirmation subject',
        // 'reconfirmationSubject' => 'Email change subject',
        // 'recoverySubject'       => 'Recovery subject',
    ],
    'enableFlashMessages' => false,
    'enableConfirmation' => false,
    'enableAccountDelete' => false,
    'emailChangeStrategy' => \dektrium\user\Module::STRATEGY_INSECURE,

    'superadmins' => ['09392201210'],
    'admins' => ['09392201210', '09122040774', '11121', '11122'],
    'agents' => [
        '09392201210',
    ],
    'reporters' => [
        '09392201210'
    ]
];
