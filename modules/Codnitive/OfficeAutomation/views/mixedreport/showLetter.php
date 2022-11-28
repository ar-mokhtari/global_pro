<?php

use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\VwRecieveletter */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .alert .alert-info {
        color: black !important;
    }
</style>
<div class="alert alert-info" style="text-align: center">
    <p style="font-size: 15px;text-align: right"> شماره نامه : <strong
                style="color: red;letter-spacing: 2px;font-size: 16px;"><?= $model->LettersNumber ?></strong></p>
    <p style="font-size: 15px;text-align: right"> تاریخ ایجاد :
        <strong style="color: red">
            <?php
            $dateParts = explode(' ', tools()->getFormattedDate($model->LettersCreateDate, 'Y-m-d H:i'));
            echo str_replace('-', '/', '[' . $dateParts[1] . ']' . '   '
                . (new \app\modules\Codnitive\Calendar\models\Persian())->getDate($dateParts[0]));
            ?>
        </strong></p>
</div>

<?php
$script = <<<JS
    var formName = $('#frm-showLetter');
    // $(formName).find('input').attr('readonly', 'disable');
    // $(formName).find('textarea').attr('readonly', 'readonly');
    $(formName).find('select').attr('disabled', true);
JS;
$this->registerJs($script);
?>

<div class="letters-form">
    <?php Pjax::begin(['id' => 'letters-showLetter', 'timeout' => false, 'enablePushState' => false]); ?>
    <?php
    $form = ActiveForm::begin([
        'options' => ['data-pjax' => 0],
        'id' => 'frm-showLetter',
    ]);
    ?>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
               aria-selected="false">اجزاء نامه</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
               aria-selected="false">مشاهده نامه</a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" id="circulation-tab" data-toggle="tab" href="#circulation" role="tab"
               aria-controls="circulation"
               aria-selected="true"><?= __('officeautomation', 'LetterCirculation') ?></a>
        </li>
    </ul>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
    <div class="tab-content" id="myTabContent">
        <?php require 'showLetterDetails/home.phtml' ?>
        <?php require 'showLetterDetails/letter_detail.phtml' ?>
        <!-- circulation.phtml have to out of pjax cause independent
        otherwise reload showLetter Action and 500 error -->
        <?php require 'showLetterDetails/circulation.phtml' ?>

    </div>
</div>
