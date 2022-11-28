<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\UsersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'UserID') ?>

    <?= $form->field($model, 'UserName') ?>

    <?= $form->field($model, 'UserFamily') ?>

    <?= $form->field($model, 'UserUserName') ?>

    <?= $form->field($model, 'UserPassword') ?>

    <?php // echo $form->field($model, 'UserGender') ?>

    <?php // echo $form->field($model, 'UserActivity') ?>

    <?php // echo $form->field($model, 'UserEmail') ?>

    <?php // echo $form->field($model, 'UserPhone') ?>

    <?php // echo $form->field($model, 'UserMobile') ?>

    <?php // echo $form->field($model, 'UserPicture') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
