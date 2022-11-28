<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\UnreadedlettersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vw-recieveletter-search">

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

    <?php // echo $form->field($model, 'FullNameSender') ?>

    <?php // echo $form->field($model, 'FullNameReciever') ?>

    <?php // echo $form->field($model, 'SendLettersID') ?>

    <?php // echo $form->field($model, 'UsersID_Reciever') ?>

    <?php // echo $form->field($model, 'SendLettersDate') ?>

    <?php // echo $form->field($model, 'SendLettersReadType') ?>

    <?php // echo $form->field($model, 'PersianLettersTypeOfAction') ?>

    <?php // echo $form->field($model, 'PersianLettersSecurity') ?>

    <?php // echo $form->field($model, 'PersianLettersArchiveType') ?>

    <?php // echo $form->field($model, 'PersianLettersFollowType') ?>

    <?php // echo $form->field($model, 'PersianLettersAttachmentType') ?>

    <?php // echo $form->field($model, 'PersianLettersType') ?>

    <?php // echo $form->field($model, 'PersianLettersResponseType') ?>

    <?php // echo $form->field($model, 'PersianLettersDraftType') ?>

    <?php // echo $form->field($model, 'PersianSendLettersReadType') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
