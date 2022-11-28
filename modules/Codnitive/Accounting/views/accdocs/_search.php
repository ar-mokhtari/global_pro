<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\codnitive\accounting\models\AccdocsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="acc-docs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'companyCode') ?>

    <?= $form->field($model, 'SecondaryDocNo') ?>

    <?= $form->field($model, 'PrimaryDocNo') ?>

    <?= $form->field($model, 'DocDate') ?>

    <?php // echo $form->field($model, 'DocTypeCode') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <?php // echo $form->field($model, 'DocTopic') ?>

    <?php // echo $form->field($model, 'MakeDate') ?>

    <?php // echo $form->field($model, 'SecondDate') ?>

    <?php // echo $form->field($model, 'DocNote') ?>

    <?php // echo $form->field($model, 'FirstUserID') ?>

    <?php // echo $form->field($model, 'SecondUserID') ?>

    <?php // echo $form->field($model, 'YearID') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
