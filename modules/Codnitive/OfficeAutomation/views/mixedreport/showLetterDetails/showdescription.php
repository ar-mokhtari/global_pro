<?php

use kartik\form\ActiveForm;

$form = ActiveForm::begin([
    'options' => ['data-pjax' => 0],
    'id' => 'frm-showDescription',
]);

?>
    <div class="tab-pane fade" id="text" role="tabpanel" aria-labelledby="text-tab">
        <?= $form->field($model, 'LettersText')->textarea(['rows' => 6, 'id' => 'ckeditor_text', 'readonly' => 'true'])->label(false) ?>
    </div>
<?php ActiveForm::end(); ?>

<?php try {

} catch (\yii\base\InvalidConfigException $e) {
} ?>
<?php
$script = <<<JS
    CKEDITOR.replace('ckeditor_text');
    var text = $("#ckeditor_text");
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