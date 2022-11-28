<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $letterNumber */
/* @var $letterSender */
/* @var $letterSendDate */
/* @var $responseLetterID */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\VwRecieveletter */
/* @var $form yii\widgets\ActiveForm */
$session = \Yii::$app->session;
?>

<?php
$script = <<<JS
    var target = $("#answer-form");
    $(document).off('submit','#answer-form form[data-pjax]');
    $(document).off('click','#add_sig');
    target.on('pjax:beforeSend',function() {
        NProgress.start();
    });
    target.on('pjax:success',function() {
         history.pushState(null,'','/officeautomation/reports/recieveletter');
         $.pjax.reload({container:'#vw-recieveletter-index',async:false});
         $(".showLetters_modal_closed").trigger('click');
         Swal.fire(after_post);
         NProgress.done();
    });

JS;
$this->registerJs($script);
?>

<div class="alert alert-info" style="text-align: center">
    <p style="font-size: 15px;text-align: right">در حال پاسخ به نامه شماره :
        <strong style="color: red"><?= $letterNumber ?></strong>
        ، که از طرف:
        <strong style="color: red"><?= $letterSender ?></strong>
        در تاریخ:
        <strong style="color: red"><?= $letterSendDate ?></strong>
        دریافت شده هستید
    </p>
</div>
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item active">
        <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
           aria-selected="true">اجزاء نامه</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
           aria-selected="false">مشاهده/ویرایش نامه</a>
    </li>
</ul>
<div class="answer-form">
    <?php Pjax::begin(['id' => 'answer-form', 'timeout' => 'false']); ?>
    <?php
    $form = ActiveForm::begin([
        'options' => ['data-pjax' => 0, 'enctype' => 'multipart/form-data'],
        'validationUrl' => ['letters/checkresponse'],
    ]);
    ?>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade in active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'LettersSubject')->textarea(['maxlength' => true, 'rows' => 5]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'LettersAbstract')->textarea(['maxlength' => true, 'rows' => 5]) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'LettersResponseType', ['enableAjaxValidation' => true])->
                    dropDownList(['' => 'اولویت پاسخگویی', 0 => 'دارد', 1 => 'ندارد']) ?>
                </div>
                <div class="col-md-2">

                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'LettersFollowType')->
                    dropDownList(['' => 'پیگیری', 0 => 'دارد', 1 => 'ندارد']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'LettersTypeOfAction')->
                    dropDownList(['' => 'نوع اقدام', 0 => 'عادی', 1 => 'اولویت بالا', 2 => 'فوری']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'LettersSecurity')->
                    dropDownList(['' => 'درجه امنیتی', 0 => 'عادی', 1 => 'محرمانه', 2 => 'سری']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'imageFile')->fileInput() ?>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <?= $form->field($model, 'LettersText')->textarea(['rows' => 6, 'id' => 'ckeditor'])->label(false) ?>
            <?= $form->field($model, 'LettersResponseID')->hiddenInput(['value' => $responseLetterID])->label(false) ?>
        </div>
    </div>
    <div class="modal-footer">
        <?= Html::submitButton('ارسال پاسخ', ['class' => 'btn', 'style' => 'float:right']) ?>
        <button type="button" class="btn" data-dismiss="modal">خروج</button>
    </div>

    <?php ActiveForm::end(); ?>
    <div>
        <button id="add_sig" class="btn" style="float: left !important;bottom: 40px;left: 90px;">
            درج امضاء
        </button>
    </div>
    <?php

    $Image = Yii::$app->request->baseUrl . '/users_picture/' . $session->get('UserSign');
    ?>
    <?php
    $script = <<<JS
    history.pushState(null,'','/officeautomation/reports/recieveletter');
    $(document).off('submit','#answer-form form[data-pjax]');
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