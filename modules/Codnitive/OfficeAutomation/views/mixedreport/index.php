<!--//circulation Modal-->
<!---->
<?php require 'modals/circulation_modal.phtml' ?>
<!---->
<!--//detail Modal-->
<!---->
<?php require 'modals/detail_modal.phtml' ?>
<!---->

<?php

use kartik\grid\GridView;
use liyunfang\contextmenu\SerialColumn;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Codnitive\OfficeAutomation\models\LettersSearch */
/* @var $LettersAttachmentType app\modules\Codnitive\OfficeAutomation\models\LettersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = __('officeautomation', 'LetterCirculation');
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
?>
<?php
$script = <<<JS
document.title = '$this->title';
JS;
$this->registerJs($script);
?>

<div class="letters-index">
    <?php Pjax::begin(['id' => 'letters-index', 'timeout' => 'false']); ?>
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
        'pjax' => false,
//        'layout' => '\n{summary}\n{pager}',
        'export' => [
            'fontAwesome' => true,
            'icon' => '',
            'label' => __('officeautomation', 'Export to'),
            'menuOptions' => ['class' => 'dropdown-menu dropdown-menu-left'],
        ],
        'toggleDataOptions' => [
            'all' => [
                'icon' => 'fa fa-arrows',
                'label' => Yii::t('officeautomation', 'Full Page'),
//                'class' => '',
                'title' => Yii::t('officeautomation', 'Full Page Show'),
            ],
            'page' => [
                'icon' => 'fa fa-clone',
                'label' => Yii::t('officeautomation', 'Pagination'),
//                'class' => '',
                'title' => Yii::t('officeautomation', 'Pagination Show'),
            ],
        ],
        'toggleDataContainer' => ['class' => 'btn-group-sm'],
        'exportContainer' => ['class' => 'btn-group-sm float-left'],
        'showPageSummary' => true,
        'resizeStorageKey' => Yii::$app->user->id . '-' . date("m"),
        'rowOptions' => function ($model, $key, $index, $gird) {
            $contextMenuId = $gird->columns[0]->contextMenuId;
            return ['data' => ['toggle' => 'context', 'target' => "#" . $contextMenuId]];
        },
        'options' => [
            'id' => 'grid_view',
        ],
        'columns' => [
            [
                'class' => SerialColumn::className(),
                'contextMenu' => true,
                'template' =>
                    '{circulation}<li class=""></li> ',
                'buttons' => [
                    'circulation' => function ($url, $model) {
                        return '<li data-id = "' . $model->LettersID . '" class="circulation letter_rightClick">
                        <i class="fa fa-edit" style="margin-right: 5px">
                        </i>' . __('officeautomation', 'Circulation') . '</li>' . PHP_EOL;
                    },
                ],
            ],
            [
                'attribute' => 'LettersNumber',
                'vAlign' => 'middle',
                'hAlign' => 'right',
                'width' => '3%',
                'format' => ['decimal', 0],
                'pageSummary' => true,
                'pageSummaryFunc' => 'f_sum',
            ],
            [
                'attribute' => 'LettersCreateDate',
                'noWrap' => true,
                'value' => function ($model) {
                    $dateParts = explode(' ', tools()->getFormattedDate($model->LettersCreateDate, 'Y-m-d H:i'));
                    return str_replace('-', '/', '[' . $dateParts[1] . ']' . '   ' . (new \app\modules\Codnitive\Calendar\models\Persian())->getDate($dateParts[0]));
                },
            ],
            [
                'attribute' => 'LettersSubject',
                'width' => '10%',
                'headerOptions' => ['style' => 'text-align:center;'],
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'contentOptions' =>
                    [
                        'style' => '
                            max-width: 350px;
                            overflow: hidden;
                            word-wrap: break-word;
                            text-overflow:ellipsis;
                            font-size: 8.5pt!important;
                            ',
                    ],
                'noWrap' => true,
                'pageSummary' => true,
                'pageSummaryFunc' => 'f_count',
            ],
            [
                'attribute' => 'FullName',
                'noWrap' => true,
                'contentOptions' =>
                    [
                        'style' => '
                            max-width: 100px;
                            overflow: hidden;
                            word-wrap: break-word;
                            text-overflow:ellipsis;
                            font-size: 8.5pt!important;
                            '
                    ]
                ,
            ],
            ['class' => 'yii\grid\ActionColumn', 'header' => '', 'template' => '{view_description}',
                'buttons' =>
                    [
                        'view_description' => function ($url, $model) {
                            return '<button onclick="show(this)" data-id="' .
                                $model->LettersID .
                                '" class="btn btn-xs btn-bitbucket show_desc" >'
                                . __('officeautomation', 'Circulation') .
                                '</button>';
                        }
                    ],
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'گزارش گردش نامه‌ها',
        ],
        'panelTemplate' => '{panelHeading}{items}{panelFooter}',
        'panelHeadingTemplate' => '
                    {title}<span style="float: left;font-size: 8px;">{export}</span>
                    <hr style="border-color: #ffffff ;box-shadow: 0 0 2px deepskyblue, 0 0 2px lightblue ;margin: 17px 0 0 0">
                    <div class="row">
                    <style>button{margin: 5px 10px 0 0;padding: 4px 5px}</style>
                        <div class="group pull-left" title="
                        ' . __('officeautomation', 'Reset Search') . '
                        "> 
                            ' . $resetFilterButton . '  
                        </div>               
                    </div>
                    ',
        'panelFooterTemplate' =>
            '{pager}{summary}{toggleData}',

    ]); ?>
    <?php
    $Lunch_modal = tools()->getBaseUrl() . tools()->getUrl('officeautomation/reports/showletter');
    /** @noinspection UnterminatedStatementJS */
    $script = /** @lang text */
        <<<JS
    function show(tag){
        var url = '$Lunch_modal',
        data_id = $(tag).data('key') !== undefined ? $(tag).data('key') : $(tag).data('id') ,
        data = {id:data_id};
        NProgress.start();
        $.post(url,data,function(msg) {
            $('#circulation_modal').modal('show').find('#circulation_modal_box').html(msg);
            NProgress.done();
        })        
    }
    $('.circulation').click(function() {
        show(this);
    });
    $('#grid_view').find('table tbody tr').dblclick(function() {
        show(this);
    });
JS;
    $this->registerJs($script);
    ?>
    <?php Pjax::end(); ?>
</div>