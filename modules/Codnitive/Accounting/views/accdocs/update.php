<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\Accounting\models\AccDocs */

$this->title = Yii::t('app', 'Update Acc Docs: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Acc Docs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="acc-docs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
