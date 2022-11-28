<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\Letters */

$this->title = 'ویرایش نامه: ' . $model->LettersID;
$this->params['breadcrumbs'][] = ['label' => 'مکاتبات', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->LettersID, 'url' => ['view', 'id' => $model->LettersID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="letters-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'block' => $block,
    ]) ?>

</div>
