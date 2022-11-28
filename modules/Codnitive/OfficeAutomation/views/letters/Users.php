<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\Letters */
/* @var $users */
/* @var $letterID */
/* @var $form yii\widgets\ActiveForm */
?>

<?php

$script = <<<JS
    $('.selectpicker').selectpicker('refresh');
    $("#frm-sendusers").on('beforeSubmit',function(e) {
        NProgress.start();
        var form = $(this);
        var formData = form.serialize();
        $.ajax(
        {
            url:form.attr('action'),
            type:form.attr('method'),
            data:formData,
            success:function(data) {
                history.pushState(null,'','/officeautomation/letters/draft');
                $.pjax.reload({container:'#letters-index',async:false});
                $(".sendDraft_modal").trigger('click');
                Swal.fire(after_post);
                NProgress.done();
            }
        }
        );
    }).on('submit',function(e) {
        $(document).off('submit','#letters-users-form form[data-pjax]');
        e.preventDefault();
    });
JS;
$this->registerJs($script);
?>
<div class="letters-form">
    <?php Pjax::begin(['id' => 'letters-users-form', 'timeout' => 'false']); ?>
    <?php
    $form = ActiveForm::begin([
        'options' => ['data-pjax' => 0],
        'action' => 'OfficeAutomation/sendforusers',
        'id' => 'frm-sendusers'
    ]);
    ?>
    <div class="modal-footer">
        <?= Html::submitButton('ارسال پیش‌نویس', ['class' => 'btn btn_post4users', 'style' => 'float:right']) ?>
        <button type="button" class="btn btn_post4users" data-dismiss="modal">خروج</button>
    </div>
    <div class="row">
        <?= $form->field($model, 'UsersID_FK')->dropDownList($users, [
            'class' => 'selectpicker form-control',
            'multiple' => 'multiple',
            'multiple data-live-search' => 'true',
            'title' => 'گیرندگان'
        ]) ?>
        <?= $form->field($model, 'LettersID_FK')->hiddenInput(['value' => $letterID])->label(false) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
    $script = <<<JS
    $('.bootstrap-select').on('click',function () {
        $(this).toggleClass('open');
    });
JS;
    $this->registerJs($script);
    ?>
    <?php Pjax::end(); ?>

</div>