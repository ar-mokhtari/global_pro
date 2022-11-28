<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\OfficeAutomation\models\Letters */

$this->title = $model->LettersID;
$this->params['breadcrumbs'][] = ['label' => 'مکاتبات', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="letters-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->LettersID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->LettersID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'LettersID',
            'LettersSubject',
            'LettersText:ntext',
            'LettersAbstract',
            'LettersCreateDate',
            'LettersNumber',
            'LettersDraftType',
            'LettersType',
            'LettersTypeOfAction',
            'LettersSecurity',
            'LettersFollowType',
            'LettersResponseType',
            'LettersResponseDate',
            'LettersResponseID',
            'LettersAttachmentType',
            'LettersAttachmentUrl',
            'LettersAttachmentFileName',
            'LettersArchiveType',
            'UsersID_FK',
        ],
    ]) ?>

</div>
