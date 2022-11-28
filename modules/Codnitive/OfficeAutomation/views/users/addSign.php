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
$script = "
history.pushState(null,'','/OfficeAutomation/users');
$(document).off('submit','#users-form form[data-pjax]');
$('#users-form').on('pjax:beforeSend',function() {
    NProgress.start();
});
$('#users-form').on('pjax:success',function() {
    history.pushState(null,'','/OfficeAutomation/users');
    $.pjax.reload({container:'#users-index',async:false});
    $('.closing').trigger('click');
    NProgress.done();
});";
$this->registerJs($script);
?>

<div class="users-form">
    <?php Pjax::begin(['ID' => 'users-form', 'timeout' => false]); ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => 0, 'enctype' => 'multipart/form-data']]); ?>
    <div class="form-group" style="margin: 5px">
        <?= Html::submitButton('ثبت امضاء', ['class' => 'btn btn-default btn-outline', 'style' => 'font-size: 8pt !important;']) ?>
    </div>
    <hr class="headerDivideLine" style="border-color: #ffffff ;box-shadow: 0 0 2px deepskyblue, 0 0 2px lightblue ;">

    <div class="row">
        <div class="col-md-7">
            <?= $form->field($model, 'ImageFile')->fileInput() ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
    $script = <<<JS
    $(document).off('submit','#users-form form[data-pjax]');
JS;
    $this->registerJs($script);
    ?>
    <?php Pjax::end(); ?>

</div>