<?php

use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
$session = \Yii::$app->session;
/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\VwReferralletters */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alert alert-info" style="text-align: center">
    <p style="font-size: 15px;text-align: right"> شماره نامه : <strong
            style="color: red"><?= $model->LettersNumber ?></strong></p>
    <p style="font-size: 15px;text-align: right"> فرستنده : <strong
            style="color: red"><?= $model->FullNameSender ?></strong></p>
    <p style="font-size: 15px;text-align: right"> تاریخ ارسال : <strong
            style="color: red"><?= $model->ReferralLettersDate ?></strong></p>
</div>

<?php
$script = <<<JS
    var formName = $('#frm-show');
    // $(formName).find('input').attr('readonly', 'disable');
    // $(formName).find('textarea').attr('readonly', 'readonly');
    $(formName).find('select').attr('disabled', true);
JS;
$this->registerJs($script);
?>

<div class="letters-form">
    <?php Pjax::begin(['id' => 'letters-showReferral', 'timeout' => false, 'enablePushState' => false]); ?>
    <?php
    $form = ActiveForm::begin([
        'options' => ['data-pjax' => 0],
        'id' => 'frm-show',
    ]);
    ?>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item active">
            <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
               aria-selected="true">اجزاء نامه</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
               aria-selected="false">مشاهده نامه</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="text-tab" data-toggle="tab" href="#text" role="tab" aria-controls="profile"
               aria-selected="false">مشاهده متن ارجاع</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade in active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'LettersSubject')->textarea(
                        [
                            'maxlength' => true,
                            'disable' => true,
                            'readonly' => true,
                            'rows' => 5
                        ]) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($model, 'LettersAbstract')->textarea(
                        [
                            'maxlength' => true,
                            'disable' => true,
                            'readonly' => true,
                            'rows' => 5
                        ]) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'LettersResponseType', ['enableAjaxValidation' => true])->
                    dropDownList(['' => 'اولویت پاسخگویی', 0 => 'دارد', 1 => 'ندارد']) ?>
                </div>
                <div class="col-md-2">
                    <?php

                    ?>
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
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <?= $form->field($model, 'LettersText')->textarea(['rows' => 6, 'id' => 'ckeditor'])->label(false) ?>
        </div>
        <div class="tab-pane fade" id="text" role="tabpanel" aria-labelledby="text-tab">
            <?= $form->field($model, 'ReferralLettersDescription')->textarea(['rows' => 6,'id'=>'ckeditor_text','readonly'=>'true'])->label(false) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    <?php

    $Image = Yii::$app->request->baseUrl . '/users_picture/' . $session->get('UserSign');
    ?>
    <?php
    $script = <<<JS
    CKEDITOR.replace('ckeditor');
    CKEDITOR.replace('ckeditor_text');
    var el = $("#ckeditor");
    var text = $("#ckeditor_text");
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
    $(document).on('load',function(){
        $.fn.modal.Constructor.prototype.enforceFocus = function () {
            modal_this = this;
            $(document).on('focusin.modal', function (e) {
                if (modal_this.text !== e.target && !modal_this.text.has(e.target).length
                // add whatever conditions you need here:
                &&
                !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select') 
                && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
                    modal_this.text.focus()
                }
            })
        };
    });
JS;
    $this->registerJs($script);
    ?>
    <?php Pjax::end(); ?>
</div>
