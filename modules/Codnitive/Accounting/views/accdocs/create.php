<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\Accounting\models\AccDocs */

$this->title = Yii::t('app', 'Create Acc Docs');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Acc Docs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acc-docs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
