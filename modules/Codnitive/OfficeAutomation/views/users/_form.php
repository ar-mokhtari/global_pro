<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
    .form-control {
        width: 100%;
    }
</style>

<?php
$script = "$('#users-form').on('pjax:beforeSend',function() {
    NProgress.start();
});
$('#users-form').on('pjax:success',function() {
    $.pjax.reload({container:'#users-index',async:false});
    $('.form-group').find('input').val(null);
    $('.form-group').find('select option').prop(\"selected\", false);
    NProgress.done();
});";
$this->registerJs($script);
?>

<div class="users-form">
    <?php Pjax::begin(['ID' => 'users-form', 'timeout' => false]); ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => 0]]); ?>
    <div class="form-group" style="margin: 5px">
        <?= Html::submitButton('ذخیره', ['class' => 'btn btn-default btn-outline', 'style' => 'font-size: 8pt !important;']) ?>
    </div>
    <hr class="headerDivideLine" style="border-color: #ffffff ;box-shadow: 0 0 2px deepskyblue, 0 0 2px lightblue ;">

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'gender')->dropDownList(['' => 'انتخاب جنسیت', 0 => 'خانم', 1 => 'آقا']) ?>
        </div>
    </div>
    <div class="row">

    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>

</div>
