<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\LettersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="letters-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'LettersID') ?>

    <?= $form->field($model, 'LettersSubject') ?>

    <?= $form->field($model, 'LettersText') ?>

    <?= $form->field($model, 'LettersAbstract') ?>

    <?= $form->field($model, 'LettersCreateDate') ?>

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

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
