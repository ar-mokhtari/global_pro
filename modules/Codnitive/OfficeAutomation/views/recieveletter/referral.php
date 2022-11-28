<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $users */
/* @var $letterID */
/* @var $*/
/* @var $model app\modules\Codnitive\OfficeAutomation\models\Referralletters */
/* @var $form yii\widgets\ActiveForm */
$session = \Yii::$app->session;
?>

<?php
$script = <<<JS
    $('.selectpicker').selectpicker('refresh');
    $(document).off('click','#add_sig');
    $("#frm-referral").on('beforeSubmit',function(e) {
        NProgress.start();
        var form = $(this);
        var formData = form.serialize();
        $.ajax(
        {
            url:form.attr('action'),
            type:form.attr('method'),
            data:formData,
            success:function(data) {
                var response = $.parseJSON(data);
                if(response.ref === 'no')
                {
                    history.pushState(null,'','/officeautomation/reports/recieveletter');
                    $.pjax.reload({container:'#vw-recieveletter-index',async:false});
                    $(".refreshing").trigger('click');
                    NProgress.done();
                    Swal.fire({
                        title: "ارسال انجام نشد!‏",
                        text: "نامه قبلا به این کاربر(ها) ارجاع داده شده است",
                        type: "error",
                        confirmButtonClass: "btn-danger",
                        confirmButtonText:'OK'
                    });
                }
                if(response.ref === 'ok')
                {
                    history.pushState(null,'','/officeautomation/reports/recieveletter');
                    $.pjax.reload({container:'#vw-recieveletter-index',async:false});
                    $(".refreshing").trigger('click');
                    Swal.fire({type: "success",
                        title:'ارجاع نامه',
                        text:'اطلاعات با موفقیت ارسال شد',
                        timer: 3000,
                        showCancelButton: false, 
                        showConfirmButton: false
                    });
                    NProgress.done();
                }
            }
        });
    }).on('submit',function(e) {
        $(document).off('submit','#letters-referral form[data-pjax]');
        $(document).off('click','#add_sig');
        e.preventDefault();
    });
JS;
$this->registerJs($script);
?>
<div class="letters-form">
    <?php Pjax::begin(['id' => 'letters-referral', 'timeout' => false, 'enablePushState' => false]); ?>
    <?php
    $form = ActiveForm::begin([
        'options' => ['data-pjax' => 0],
        'action' => '../../officeautomation/letters/sendreferral',
        'id' => 'frm-referral'
    ]);
    ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'UsersID_Receiver')->dropDownList($users, [
                'class' => 'selectpicker form-control',
                'multiple' => 'multiple',
                'multiple data-live-search' => 'true',
                'title' => 'گیرنده(گان)'
            ]) ?>
            <?= $form->field($model, 'LettersID_FK')->
            hiddenInput(['value' => $letterID])->label(false) ?>
            <?= $form->field($model, 'UsersID_Sender')->
            hiddenInput(['value' => tools()->getUser()->identity->id])->label(false) ?>
        </div>
    </div>
    <div class="row">
        <?= $form->field($model, 'ReferralLettersDescription')->
        textarea(['rows' => 6, 'id' => 'ckeditor'])->label(false) ?>
    </div>
    <div class="modal-footer">
        <?= Html::submitButton('ارسال ارجاع', ['class' => 'btn btn_post4users', 'style' => 'float:right']) ?>
        <button type="button" class="btn btn_post4users" data-dismiss="modal">خروج</button>
    </div>


    <?php ActiveForm::end(); ?>
    <div>
        <button id="add_sig" class="btn btn_post4users" style="float: left !important;bottom: 40px;left: 90px;">
            درج امضاء
        </button>
    </div>
    <?php

    $Image = Yii::$app->request->baseUrl . '/users_picture/' . $session->get('UserSign');
    ?>
    <?php
    $script = <<<JS
    $('.bootstrap-select').on('click',function () {
        $(this).toggleClass('open');
    });
    CKEDITOR.replace('ckeditor');
    var el = $("#ckeditor");
    $(document).on('load',function(){
        $.fn.modal.Constructor.prototype.enforceFocus = function () {
            modal_this = this;
            $(document).on('focusin.modal', function (e) {
                if (modal_this.el !== e.target && !modal_this.el.has(e.target).length
                // add whatever conditions you need here:
                &&
                !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select') 
                && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
                    modal_this.el.focus()
                }
            })
        };
    });
    $(document).on('click','#add_sig',function() {
    CKEDITOR.instances['ckeditor'].insertHtml('<img src="$Image" style="width:120px;height:120px">');
    });
JS;
    $this->registerJs($script);
    ?>
    <?php Pjax::end(); ?>
</div>