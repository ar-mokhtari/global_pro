<?php

use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Codnitive\CentralOffice\models\coding\CodingSearch */
/* @var $LettersAttachmentType app\modules\Codnitive\CentralOffice\models\coding\CodingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'لیست اسناد';
?>

<style>
    .panel-heading {
        padding-bottom: 0;
    }
</style>
<div class="list-index">
    <?php Pjax::begin(['id' => 'list-index', 'timeout' => 'false']); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
    Yii::$app->params['bsVersion'] = '3';
    ?>
    <?php
    $buttonText = __('core', 'Reset Filter');
    $url = '/' . app()->request->pathInfo;
    $resetFilterButton = <<<BTN
        <a style="margin: 0.4rem 10px" class="pull-left" href="$url"><span class="btn btn-outline">$buttonText</span></a>

BTN;
    ?>
    <?= /** @noinspection PhpUnhandledExceptionInspection */
    GridView::widget([
        'id' => 'db_grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'hover' => true,
        'responsive' => true,
        'resizableColumns' => true,
        'persistResize' => true,
        'bordered' => true,
        'pjax' => false,
        'pager' => [
            'firstPageLabel' => 'اولین',
            'lastPageLabel' => 'آخرین',
            'nextPageLabel' => 'صفحه بعد',
            'prevPageLabel' => 'صفحه قبل'
        ],
//        'layout' => '\n{summary}\n{pager}',
        'export' => [
            'fontAwesome' => true,
            'icon' => '',
            'label' => __('accounting', 'Export to'),
            'menuOptions' => ['class' => 'dropdown-menu dropdown-menu-left'],
        ],
        'toggleDataOptions' => [
            'all' => [
                'icon' => 'fa fa-arrows',
                'label' => Yii::t('accounting', 'Full Page'),
//                'class' => '',
                'title' => Yii::t('accounting', 'Full Page Show'),
            ],
            'page' => [
                'icon' => 'fa fa-clone',
                'label' => Yii::t('accounting', 'Pagination'),
//                'class' => '',
                'title' => Yii::t('accounting', 'Pagination Show'),
            ],
        ],
        'toggleDataContainer' => ['class' => 'btn-group-sm'],
        'exportContainer' => ['class' => 'btn-group-sm float-left'],
        'showPageSummary' => true,
//        'resizeStorageKey' => Yii::$app->user->id . '-' . date("m"),
        'options' => [
            'id' => 'grid_view',
        ],
        'columns' => [
            [
                'class' => '\kartik\grid\RadioColumn',
                'showClear' => true,
                'clearOptions' => ['class' => 'close', 'title' => __('accounting', 'Clear selection')],
            ],
            [
                'attribute' => 'id',
                'vAlign' => 'middle',
                'hAlign' => 'right',
                'width' => '3%',
                'format' => ['decimal', 0],
                'pageSummary' => true,
                'pageSummaryFunc' => 'f_sum',
                'hidden' => true,
            ],
            [
                'attribute' => 'SecondaryDocNo',
                'hAlign' => 'center',
                'pageSummary' => true,
                'pageSummaryFunc' => 'f_count',
            ],
             [
                'attribute' => 'PrimaryDocNo',
                'hAlign' => 'center',
                'pageSummary' => true,
                'pageSummaryFunc' => 'f_count',
            ],
            [
                'attribute' => 'DocDate',
                'value' => function ($model) {
                    $dateParts = explode(' ', tools()->getFormattedDate($model->DocDate, 'Y-m-d H:i'));
                    return str_replace('-', '/', (new \app\modules\Codnitive\Calendar\models\Persian())->getDate($dateParts[0]));
                }
            ],
            [
                'attribute' => 'DocTopic',
                'headerOptions' => ['style' => 'text-align:center;'],
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'width' => '60%',
                'noWrap' => true,
            ],
            [
                'attribute' => 'FirstUserID',
                'noWrap' => true,
            ],
             [
                'attribute' => 'Status',
                'noWrap' => true,
                'headerOptions' => ['style' => 'text-align:center;word-wrap: break-word;'],
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'لیست اسناد حسابداری',
        ],
        'panelTemplate' => '{panelHeading}{items}{panelFooter}',
        'panelHeadingTemplate' => '
                    {title}<span style="float: left;font-size: 8px;">{export}</span>
                    <hr style="border-color: #ffffff ;box-shadow: 0 0 2px deepskyblue, 0 0 2px lightblue ;margin: 17px 0 0 0">
                    <div class="row">
                    <style>button{margin: 5px 10px 0 0;padding: 4px 5px}</style>
                        <button id="add_draft" style="font-size: 8pt !important;" class="btn btn-default">
                            ایجاد سند جدید
                        </button> 
                    ' . $resetFilterButton . '                 
                    </div>
                    ',
        'panelFooterTemplate' =>
            '{pager}{summary}{toggleData}',

    ]); ?>

    <?php Pjax::end(); ?>

</div>