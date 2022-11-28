<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\Letters */


$this->params['breadcrumbs'][] = ['label' => 'مکاتبات', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="letters-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'block' => $block,
    ]) ?>

</div>
