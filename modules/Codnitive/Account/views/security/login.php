<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\models\LoginForm;
use dektrium\user\widgets\Connect;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign in');
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="home2"></div>
<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<section class="login-wrap">
    <div class="main_w3agile">
        <h4 class="text-center text-white"><?= Html::encode($this->title) ?></h4>
        <div class="hr"></div>

        <div class="login-form">
            <!-- signin form -->
            <div class="signin_wthree">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                    'options' => ['autocomplete' => 'off'],
                ]) ?>
                <div class="group" data-tip="<?= __('user', 'Username') ?>">
                        <?php if ($module->debug): ?>
                            <?= $form->field($model, 'login', [
                                'inputOptions' => [
                                    'autofocus' => 'autofocus',
                                    'class' => 'form-control input',
                                    'tabindex' => '1']])->dropDownList(LoginForm::loginList());
                            ?>
                        <?php else: ?>
                            <?= $form->field($model, 'login',
                                ['inputOptions' => ['autofocus' => 'autofocus',
                                    'class' => 'form-control input', 'tabindex' => '1',
                                    'placeholder' => __('user', 'Username')]]
                            );
                            ?>
                        <?php endif ?>
                    </div>
                    <div class="group password-field-wrapper">
                        <?php if ($module->debug): ?>
                            <div class="alert alert-warning">
                                <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                            </div>
                        <?php else: ?>
                            <?= $form->field(
                                $model,
                                'password',
                                ['inputOptions' => ['class' => 'form-control input', 'tabindex' => '2']])
                                ->passwordInput()
                                ->label(Yii::t('user', 'Password')) ?>
                        <?php endif ?>
                        <i class="fas fa-eye password-viewer"></i>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                codnitive.togglePassworkVisibilite('#login-form-password', '.password-viewer');
                            });
                        </script>
                    </div>
                    <?php // @link https://github.com/himiklab/yii2-recaptcha-widget ?>
                    <?= $form->field($model, 'reCaptcha')->label(false)->widget(
                        \himiklab\yii2\recaptcha\ReCaptcha3::className(),
                        [
                            'action' => 'login',
                        ]
                    ) ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="group remember-me">
                            <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '3']) ?>
                        </div>
                        <span class="fz-14 text-white d-inline ml-2 mr-0 forgot-password"><?= ($module->enablePasswordRecovery ?
                                Html::a(
                                    Yii::t('user', 'Forgot password?'),
                                    tools()->getUrl('user/recovery/request'),
                                    ['tabindex' => '5', 'class' => 'text-white']
                                ) : '') ?></span>
                    </div>
                    <div class="d-flex justify-content-center group text-center">
                        <?= Html::submitButton(
                            Yii::t('user', 'Sign in'),
                            ['class' => 'button', 'tabindex' => '4']
                        ) ?>
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <?php if ($module->enableConfirmation): ?>
                            <p class="text-center">
                                <?= Html::a(
                                    Yii::t('user', 'Didn\'t receive confirmation message?'),
                                    tools()->getUrl('user/registration/resend'),
                                    ['class' => 'fz-14 text-white']) ?>
                            </p>
                        <?php endif ?>
                        <?php if ($module->enableRegistration): ?>
                            <p class="text-center">
                                <?= Html::a(
                                    Yii::t('user', 'Don\'t have an account? Sign up!'),
                                    tools()->getUrl('user/registration/register'),
                                    ['class' => 'fz-14 text-white']
                                ) ?>
                            </p>
                        <?php endif ?>
                        <?= Connect::widget([
                            'baseAuthUrl' => ['/user/security/auth'],
                        ]) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
            <!-- //signin form -->
        </div>
    </div>

</section>
