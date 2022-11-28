<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\Letters */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$script = <<<JS
    var target = $("#letters-add-attach");
    $(document).off('submit','#letters-form form[data-pjax]');
    target.on('pjax:beforeSend',function() {
        NProgress.start();
    });
    target.on('pjax:success',function() {
        history.pushState(null,'','/officeautomation/letters/draft');
        $.pjax.reload({container:'#letters-index',async:false});
        $(".add_draft_modal_closed").trigger('click');
        Swal.fire(after_post);
        NProgress.done();
    });
JS;
$this->registerJs($script);
?>

<div class="letters-form">
    <?php Pjax::begin(['id' => 'letters-add-attach', 'timeout' => 'false']); ?>
    <?php
    $form = ActiveForm::begin([
        'options' => ['data-pjax' => 0, 'enctype' => 'multipart/form-data'],
    ]);
    ?>
    <div class="row">
        <?= $form->field($model, 'imageFile')->fileInput() ?>
    </div>
    <div class="modal-footer">
        <?= Html::submitButton('ثبت پیوست', ['class' => 'btn', 'style' => 'float:right']) ?>
        <button type="button" class="btn" data-dismiss="modal">خروج</button>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
    $script = <<<JS
    history.pushState(null,'','/officeautomation/letters/draft');
    $(document).off('submit','#letters-form form[data-pjax]');
JS;
    $this->registerJs($script);
    ?>
    <?php Pjax::end(); ?>

</div>