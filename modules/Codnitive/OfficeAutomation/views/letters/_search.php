<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\Codnitive\CentralOffice\blocks\AddForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\LettersSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$firstDay = app()->session->get('firstDay');
$lastDay = app()->session->get('lastDay');
$script = <<<JS
$("#LettersCreateDate_From").val('$firstDay');
$("#LettersCreateDate_To").val('$lastDay');
JS;
$this->registerJs($script);
?>

<div class="letters-search">

    <?php $form = ActiveForm::begin([
        'action' => ['draft'],
        'method' => 'get',
        'options' => [
            'data-pjax' => true,
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(__('account','search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(__('account','Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>
    <div class="row panel panel-default">
        <div class="pull-right col-md-12 ">
            <?= __('account', 'create_at') ?>
        </div>
        <div class="col-md-6">
            <?= $block->html()->getHiddenField($form, $model, 'LettersCreateDate_From'); ?>
            <?= $block->OfficeHtml()->getDateField($form, $model, 'LettersCreateDate_From_P', $this, [
                'class' => 'hotel-datepicker LettersCreateDate_From-datepicker',
                'form_group_class' => 'LettersCreateDate',
                'remove_label' => false,
                'icon' => 'fa fa-calendar',
                'placeholder' => __('account', 'From date'),
                'date_options' => [
                    'GroupId' => 'LettersCreateDate',
                    'Trigger' => 'click',
                    'EnableTimePicker' => false,
                    'TargetSelector' => '#LettersCreateDate_From',
                    'ToDate' => false,
                    'FromDate' => true,
                    'DisableBeforeToday' => false,
                    'Disabled' => false,
                    'Format' => 'yyyy/MM/dd',
                    'IsGregorian' => false,
                    'EnglishNumber' => false,
                    'placement' => 'auto',
                    'targetDateSelector' => '#LettersCreateDate_From',
                    'targetTextSelector' => '#LettersCreateDate_From_P',
                    'dateFormat' => 'yyyy/MM/dd',
//            'modalMode' => true,
//            'yearOffset' => 1,
//            'disabledDays' => [5, 6],
                    'textFormat' => 'yyyy/MM/dd',
//            'monthsToShow' => [0, 1],
//            'rangeSelector' => true,
                    'showCalendarTypeToggleBtn' => true,
                ],
            ])->label(__('account', 'From date'));
            ?>
        </div>
        <div class="col-md-6">
            <?= $block->html()->getHiddenField($form, $model, 'LettersCreateDate_To'); ?>
            <?= $block->OfficeHtml()->getDateField($form, $model, 'LettersCreateDate_To_P', $this, [
                'class' => 'hotel-datepicker LettersCreateDate_To-datepicker',
                'form_group_class' => 'LettersCreateDate',
                'remove_label' => false,
                'icon' => 'fa fa-calendar',
                'placeholder' => __('account', 'To date'),
                'date_options' => [
                    'GroupId' => 'LettersCreateDate',
                    'Trigger' => 'click',
                    'EnableTimePicker' => false,
                    'TargetSelector' => '#LettersCreateDate_To',
                    'ToDate' => true,
                    'FromDate' => false,
                    'DisableBeforeToday' => false,
                    'Disabled' => false,
                    'Format' => 'yyyy/MM/dd',
                    'IsGregorian' => false,
                    'EnglishNumber' => false,
                    'placement' => 'auto',
                    'targetDateSelector' => '#LettersCreateDate_To',
                    'targetTextSelector' => '#LettersCreateDate_To_P',
                    'dateFormat' => 'yyyy/MM/dd',
                    //            'modalMode' => true,
                    //            'yearOffset' => 1,
                    //            'disabledDays' => [5, 6],
                    'textFormat' => 'yyyy/MM/dd',
                    //            'monthsToShow' => [0, 1],
                    //            'rangeSelector' => true,
                    'showCalendarTypeToggleBtn' => true,
                ],
            ])->label(__('account', 'To date'));
            ?>

        </div>

    </div>


    <?= $form->field($model, 'LettersSubject') ?>

    <?= $form->field($model, 'LettersText') ?>

    <?= $form->field($model, 'LettersAbstract') ?>

    <?= $block->OfficeHtml()->getTextarea($form, $model, 'LettersSubject', ['rows' => '5']) ?>
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

    <?php // echo $form->field($model, 'LettersNumber') ?>

    <?php // echo $form->field($model, 'LettersDraftType') ?>

    <?php // echo $form->field($model, 'LettersType') ?>

    <?php // echo $form->field($model, 'LettersTypeOfAction') ?>

    <?php // echo $form->field($model, 'LettersSecurity') ?>

    <?php // echo $form->field($model, 'LettersFollowType') ?>

    <?php // echo $form->field($model, 'LettersResponseType') ?>

    <?php // echo $form->field($model, 'LettersResponseDate') ?>

    <?php // echo $form->field($model, 'LettersResponseID') ?>

    <?php // echo $form->field($model, 'LettersAttachmentType') ?>

    <?php // echo $form->field($model, 'LettersAttachmentUrl') ?>

    <?php // echo $form->field($model, 'LettersAttachmentFileName') ?>

    <?php // echo $form->field($model, 'LettersAttachFileExtention') ?>

    <?php // echo $form->field($model, 'LettersArchiveType') ?>

    <?php // echo $form->field($model, 'UsersID_FK') ?>


    <?php ActiveForm::end(); ?>

</div>
