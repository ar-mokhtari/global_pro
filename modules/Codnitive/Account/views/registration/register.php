<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use kartik\password\PasswordInput;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Sign up');
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="home2"></div>

<section class="login-wrap">
    <div class="main_w3agile">
        <h4 class="text-center text-white"><?= Html::encode($this->title) ?></h4>
        <div class="hr"></div>

        <div class="login-form">
            <!-- signup form -->
            <div class="signin_wthree">
                <?php $form = ActiveForm::begin([
                    'id' => 'registration-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'options' => ['autocomplete' => 'off'],
                ]); ?>

                <?php /*<div class="group">
                <?= $form->field($model, 'email', ['inputOptions' => ['class' => 'form-control input', 'autofocus' => 'autofocus']]) ?>
                </div>*/ ?>
                <div class="group">
                <?= $form->field($model, 'username', ['inputOptions' => ['class' => 'form-control input']]) ?>
                </div>

                <?php if ($module->enableGeneratingPassword == false): ?>
                <div class="group password-field-wrapper">
                    <?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control input']])->passwordInput() ?>
                    <?php /*<?= $form->field($model, 'password')->widget(PasswordInput::classname(), [
                        'pluginOptions' => [
                            'showMeter' => true,
                            'toggleMask' => false
                        ]
                    ]);
                    ?>*/ ?>
                    <i class="fas fa-eye password-viewer"></i>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            codnitive.togglePassworkVisibilite('#register-form-password', '.password-viewer');
                        });
                    </script>
                </div>
                <?php endif ?>
                <?php // @link https://github.com/himiklab/yii2-recaptcha-widget ?>
                <?= $form->field($model, 'reCaptcha')->label(false)->widget(
                    \himiklab\yii2\recaptcha\ReCaptcha3::className(),
                    [
                        'action' => 'registration',
                    ]
                ) ?>

                <div class="d-flex justify-content-center group text-center mt-5">
                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <div class="hr"></div>
        <div class="foot-lnk">
            <p class="text-center">
                <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), tools()->getUrl('user/login'), ['class' => 'fz-14 text-white']) ?>
            </p>
        </div>
        <!-- //signup form -->
    </div>
</section>
