<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\VwReferralletters */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vw-referralletters-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ReferralLettersID')->textInput() ?>

    <?= $form->field($model, 'ReferralLettersDate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ReferralLettersDescription')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'LettersID_FK')->textInput() ?>

    <?= $form->field($model, 'UsersID_Sender')->textInput() ?>

    <?= $form->field($model, 'UsersID_Receiver')->textInput() ?>

    <?= $form->field($model, 'ReferralLettersReadType')->textInput() ?>

    <?= $form->field($model, 'LettersID')->textInput() ?>

    <?= $form->field($model, 'LettersSubject')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LettersText')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'LettersAbstract')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LettersCreateDate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LettersNumber')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LettersDraftType')->textInput() ?>

    <?= $form->field($model, 'LettersType')->textInput() ?>

    <?= $form->field($model, 'LettersTypeOfAction')->textInput() ?>

    <?= $form->field($model, 'LettersSecurity')->textInput() ?>

    <?= $form->field($model, 'LettersFollowType')->textInput() ?>

    <?= $form->field($model, 'LettersResponseType')->textInput() ?>

    <?= $form->field($model, 'LettersResponseDate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LettersResponseID')->textInput() ?>

    <?= $form->field($model, 'LettersAttachmentType')->textInput() ?>

    <?= $form->field($model, 'LettersAttachmentUrl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LettersAttachmentFileName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LettersAttachFileExtention')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LettersArchiveType')->textInput() ?>

    <?= $form->field($model, 'UsersID_FK')->textInput() ?>

    <?= $form->field($model, 'FullNameSender')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FullNameReceiver')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FullCreator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PersianLettersTypeOfAction')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PersianLettersSecurity')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PersianLettersArchiveType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PersianLettersFollowType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PersianLettersAttachmentType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PersianLettersType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PersianLettersResponseType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PersianLettersDraftType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PersianReferralLettersReadType')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
