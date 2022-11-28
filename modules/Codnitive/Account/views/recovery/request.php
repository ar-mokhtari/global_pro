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

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\RecoveryForm $model
 */

$this->title = Yii::t('user', 'Recover your password');
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="home2"></div>

<section class="login-wrap">
    <div class="main_w3agile">
        <h4 class="text-center text-white"><?= Html::encode($this->title) ?></h4>
        <div class="hr"></div>

        <div class="login-form">
            <!-- signin form -->
            <div class="signin_wthree">
                <?php $form = ActiveForm::begin([
                    'id' => 'password-recovery-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'options' => ['autocomplete' => 'off'],
                ]); ?>

                <div class="group">
                <?php /*<?= $form->field($model, 'email', ['inputOptions' => ['class' => 'form-control input']])->textInput(['autofocus' => true]) ?>*/ ?>
                <?= $form->field($model, 'cellphone', ['inputOptions' => ['class' => 'form-control input']])->textInput(['autofocus' => true]) ?>
                </div>
                <?php // @link https://github.com/himiklab/yii2-recaptcha-widget ?>
                <?php /*<?= $form->field($model, 'reCaptcha')->label(false)->widget(
                    \himiklab\yii2\recaptcha\ReCaptcha3::className(),
                    [
                        'action' => 'request',
                    ]
                ) ?>*/ ?>

                <div class="d-flex justify-content-center group text-center mt-5">
                <?= Html::submitButton(Yii::t('user', 'Continue'), ['class' => 'button']) ?><br>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
            <div class="hr"></div>
            <div class="foot-lnk">
                <p class="text-center">
                    <?= Html::a(__('template', 'Back to login page'), tools()->getUrl('user/login'), ['class' => 'fz-14 text-white']) ?>
                </p>
            </div>
            <!-- //signin form -->
        </div>
    </div>
</section>
