<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\Users */

$this->title = 'ویرایش کاربر: ' . $model->UserID;
$this->params['breadcrumbs'][] = ['label' => 'کاربران', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->UserID, 'url' => ['view', 'id' => $model->UserID]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>
<div class="users-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
