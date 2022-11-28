<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$session = \Yii::$app->session;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\Letters */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$script = <<<JS
    $(document).off('click','#add_sig');
    $("#frm-updating").on('beforeSubmit',function(e) {
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
                $(".add_draft_modal_closed").trigger('click');
                Swal.fire(after_post);
                NProgress.done();
            }
        }
        );
    }).on('submit',function(e) {
        $(document).off('submit','#letters-updating form[data-pjax]');
        $(document).off('click','#add_sig');
        e.preventDefault();
        
    });
JS;
$this->registerJs($script);
?>
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

<div class="letters-form">
    <?php Pjax::begin(['id' => 'letters-updating', 'timeout' => 'false',]); ?>
    <?php
    $form = ActiveForm::begin([
        'options' => ['data-pjax' => 0],
        'validationUrl' => 'letters/check-response-date',
        'id' => 'frm-updating'
    ]);
    ?>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade in active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row">
                <div class="col-md-3">
                    <?= $block->OfficeHtml()->getTextarea($form, @$model, 'LettersSubject', ['rows' => '5']); ?>
                    <?= $block->OfficeHtml()->getHiddenField($form, @$model, 'LettersID', ['rows' => '5']); ?>
                </div>
                <div class="col-md-4">
                    <?= $block->OfficeHtml()->getTextarea($form, @$model, 'LettersAbstract', ['rows' => '5']); ?>
                </div>
                <div class="col-md-2">
                    <?= $block->OfficeHtml()->getDropdownList($form, @$model, 'LettersResponseType',
                        [
                            0 => 'دارد', 1 => 'ندارد',
                        ],
                        [
                            'remove_label' => false,
                            'enableAjaxValidation' => true,
                            'validationUrl' => 'letters/checkresponse',
                            'fastselect' => [
                                'removeQuickSearch' => true,
                            ]
                        ]
                        , $this) ?>
                </div>
                <div class="col-md-2">
                    <?= $block->OfficeHtml()->getHiddenField($form, $model, 'LettersResponseDate') ?>
                    <?= $block->OfficeHtml()->getDateField($form, $model, 'LettersResponseDate_Persian', $this, [
                        'class' => 'LettersResponseDate-datepicker',
                        'form_group_class' => '',
                        'remove_label' => true,
                        'icon' => '',
                        'date_options' => [
                            'targetDateSelector' => '#LettersResponseDate',
                            'targetTextSelector' => '#LettersResponseDate_Persian',
                            'dateFormat' => 'yyyy/MM/dd',
                            'modalMode' => true,
                            //'yearOffset' => 1,
                            'disabledDays' => [5, 6],
                            'enableTimePicker' => false,
                            'textFormat' => 'yyyy/MM/dd',
                            'isGregorian' => false,
                            'disableBeforeToday' => true,
                            // 'monthsToShow' => [0, 1],
                            // 'rangeSelector' => true,
                            'englishNumber' => true,
                            // 'placement' => 'auto',
                            'showCalendarTypeToggleBtn' => true,
                        ]
                    ])
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $block->OfficeHtml()->getDropdownList($form, @$model, 'LettersFollowType',
                        [
                            0 => 'دارد', 1 => 'ندارد',
                        ],
                        [
                            'remove_label' => false,
                            'fastselect' => [
                                'removeQuickSearch' => true,
                            ]
                        ]
                        , $this) ?>
                </div>
                <div class="col-md-3">
                    <?= $block->OfficeHtml()->getDropdownList($form, @$model, 'LettersTypeOfAction',
                        [
                            0 => 'عادی', 1 => 'اولویت بالا', 2 => 'فوری',
                        ],
                        [
                            'remove_label' => false,
                            'fastselect' => [
                                'removeQuickSearch' => true,
                            ]
                        ]
                        , $this) ?>
                </div>
                <div class="col-md-3">
                    <?= $block->OfficeHtml()->getDropdownList($form, @$model, 'LettersSecurity',
                        [
                            0 => 'عادی', 1 => 'محرمانه', 2 => 'سری',
                        ],
                        [
                            'remove_label' => false,
                            'fastselect' => [
                                'removeQuickSearch' => true,
                            ]
                        ]
                        , $this) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $block->OfficeHtml()->getFileInput($form, $model, 'imageFile', [
                        'pluginOptions' => [
                            'showUpload' => true,
                            'showCancel' => false,
                            'maxFileCount' => 1,
                            'validateInitialCount' => true,
                            'uploadAsync' => false,
                            'initialCaption' => __('officeautomation', 'Please upload file here'),
                            'showPreview' => true,
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <?= $form->field($model, 'LettersText')->textarea(['rows' => 6, 'id' => 'ckeditor'])->label(false) ?>
        </div>
    </div>
    <div class="modal-footer">
        <?= Html::submitButton('ثبت پیش‌نویس', ['class' => 'btn', 'style' => 'float:right']) ?>
        <button type="button" class="btn" style="float: left" data-dismiss="modal">خروج</button>
        <button id="add_sig" class="btn" style="float: left !important;bottom: 40px;left: 90px;">
            درج امضاء
        </button>
    </div>

    <?php ActiveForm::end(); ?>
    <?php
    $this->registerJsFile(Yii::$app->request->baseUrl . '/web/ckeditor/ckeditor.js');
    $Image = Yii::$app->request->baseUrl . '/web/users_picture/' . $session->get('UserSign');
    ?>
    <?php
    $script = <<<JS
    history.pushState(null,'','/officeautomation/letters/draft');
    $(document).off('submit','#letters-updating form[data-pjax]');    
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
