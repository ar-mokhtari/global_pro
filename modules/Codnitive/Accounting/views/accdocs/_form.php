<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\Codnitive\Accounting\models\AccDocs */
/* @var $form yii\widgets\ActiveForm */
/* @var $pagination yii\widgets\ActiveForm */
/* @var $dataProvider_Details yii\widgets\ActiveForm */
/* @var $searchModel_Details yii\widgets\ActiveForm */
?>
<?php
$script = <<<JS
    $(document).off('submit','#docs-form-pjax form[data-pjax]');
JS
?>
<div class="acc-docs-form">
    <?php Pjax::begin(['id' => 'docs-form-pjax', 'timeout' => 'false']); ?>
    <?php $form = ActiveForm::begin([
        'id' => 'docs-form',
//        'template' => '<div class="inline">{input}{label}</div>{error}{hint}',
        'options' => ['autocomplete' => 'off',],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
            'labelOptions' => ['class' => 'col-sm-3 control-label text-left'],
        ],
    ]); ?>
    <div class="row container">
        <div class="col-12">
            <div class="col-lg-3 col-xs-4 pull-right">
                <?= $form->field($model, 'companyCode')->textInput() ?>
                <?= $form->field($model, 'DocTypeCode')->textInput() ?>
                <?= $form->field($model, 'Status')->textInput() ?>
            </div>
            <div class="col-lg-3 col-xs-4 pull-left">
                <?= $form->field($model, 'SecondaryDocNo')->textInput(['style' => 'color:red;font-size:20px']) ?>
                <?= $form->field($model, 'PrimaryDocNo')->textInput() ?>
                <?= $form->field($model, 'DocDate')->textInput() ?>
            </div>
            <div class="col-lg-12 col-xs-4">
                <?= $form->field($model, 'DocTopic', [
                    'template' => '
                       <div class="pull-right">{label}</div>
                       <div class="input-group col-lg-12">
                          <span class="input-group-addon">
                             <i class="fa fa-newspaper-o"></i>
                          </span>
                          {input}
                       </div>
                    {error}{hint}'
                ])->textarea(['maxlength' => 1]) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <!--    Pagination    -->
    <div class="row container">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <?php
            try {
                echo LinkPager::widget([
                    'id' => 'my-pager',
                    'hideOnSinglePage' => true,
                    'pagination' => $pagination,
//                    'activePageCssClass' => 'button',
//                    'disabledPageCssClass' => 'button',
                    'maxButtonCount' => 0,
                    'firstPageLabel' => __('accounting', 'firstPageLabel'),
                    'lastPageLabel' => __('accounting', 'lastPageLabel'),
                    'nextPageLabel' => __('accounting', 'nextPageLabel'),
                    'prevPageLabel' => __('accounting', 'prevPageLabel'),
                    'options' => [
                        'class' => 'pagination'
                    ],
                ]);
            } catch (Exception $e) {
            }
            ?>
        </div>
        <div class="col-md-4"></div>
    </div>
    <!--    Pagination    -->

    <?php
    $buttonText = __('core', 'Reset Filter');
    $url = '/' . app()->request->pathInfo;
    $resetFilterButton = <<<BTN
        <a style="margin: 0.4rem 10px" class="pull-left" href="$url"><span class="btn btn-outline">$buttonText</span></a>

BTN;
    ?>
    <?= /** @noinspection PhpUnhandledExceptionInspection */
    GridView::widget([
        'id' => 'grid_view',
        'dataProvider' => $dataProvider_Details,
        'filterModel' => $searchModel_Details,
        'hover' => true,
        'responsive' => true,
        'resizableColumns' => true,
        'persistResize' => true,
        'condensed' => true,
        'bordered' => true,
        'floatHeader' => false,
        'layout' => "{items}",
//        'headerRowOptions' => ['class' => 'center'],
        'options' => ['id' => 'grid_view','style' => 'font-size:12px;'],
//        'floatHeaderOptions' => ['top' => '0'],
        'pjax' => true,
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
        'columns' => [
            [
                'class' => '\kartik\grid\RadioColumn',
                'showClear' => true,
                'clearOptions' => ['class' => 'close', 'title' => __('accounting', 'Clear selection')],
            ],
            [
                'attribute' => 'Debit',
                'hidden' => true,
                'pageSummary' =>
                    function ($summary, $data, $widget) {
                        app()->session->set('debit_summary', $summary);
                        return
                            $summary;
                    },
                'pageSummaryFunc' => 'f_sum',
            ],
            [
                'attribute' => 'doc_id',
                'hidden' => true,
                'width' => '3%',
            ],
            [
                'attribute' => 'TopicCode',
                'hAlign' => 'center',
                'pageSummary' => 'جمع',
                'pageSummaryFunc' => 'f_count',
            ],
            [
                'attribute' => 'DetailCode',
                'hAlign' => 'center',
            ],
            [
                'attribute' => 'CTopicCode1',
                'hAlign' => 'center',
            ],
            [
                'attribute' => 'CTopicCode2',
                'hAlign' => 'center',
            ],
            [
                'attribute' => 'CTopicCode3',
                'hAlign' => 'center',
            ],
            [
                'attribute' => 'Comment',
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
                            '
                    ],
                'noWrap' => false,
                'width' => '40%',
                'value' => function ($model, $key, $index) {
                    return $model->Comment;
                },
                'pageSummary' =>
                    function ($summary, $data, $widget) {
                        return '<span style="display: table;
                                             white-space:normal;
                                             width: 100%;
                                             font-size: 1.1rem;
                                             color: lightslategrey!important;
                                             font-weight: normal;">' .
                            tools()->numberToWords(app()->session->get('debit_summary')) .
                            '</span>';
                    }
                ,
            ],
            [
                'attribute' => 'Debit',
                'noWrap' => true,
                'hAlign' => 'center',
                'pageSummary' => true,
                'pageSummaryFunc' => 'f_sum',
                'format' => ['decimal', 0],
                'contentOptions' =>
                    [
                        'style' => '
                            max-width: 350px;
                            overflow: hidden;
                            word-wrap: break-word;
                            text-overflow:ellipsis;
                            font-size: 8.5pt!important;
                            '
                    ],
                'width' => '20%',
                'pageSummaryFormat' => ['decimal', 0],
            ],
            [
                'attribute' => 'Credit',
                'noWrap' => true,
                'hAlign' => 'center',
                'pageSummary' => true,
//                    function ($summary, $data, $widget) {
//                        return __('accounting', 'credit_short') . $summary;
//                    },
                'pageSummaryFunc' => 'f_sum',
                'format' => ['decimal', 0],
                'contentOptions' =>
                    [
                        'style' => '
                            max-width: 350px;
                            overflow: hidden;
                            word-wrap: break-word;
                            text-overflow:ellipsis;
                            font-size: 8.5pt!important;
                            '
                    ],
                'width' => '20%',
                'pageSummaryFormat' => ['decimal', 0],
            ],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'لیست آرتیکل ها',
        ],
        'panelTemplate' => '{items}',
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
    <!--   Action Buttons    -->
    <div class="row container">
        <div class="col-sm-1">
            <?= Html::submitButton('&nbsp;&nbsp;' . __('accounting', 'Create') . '&nbsp;&nbsp;', ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="col-sm-1">
            <?= Html::submitButton('&nbsp;&nbsp;' . __('accounting', 'Edit') . '&nbsp;&nbsp;', ['class' => 'btn btn-warning']) ?>
        </div>
        <div class="col-sm-1">
            <?= Html::submitButton('&nbsp;&nbsp;' . __('accounting', 'Delete') . '&nbsp;&nbsp;', ['class' => 'btn btn-danger']) ?>
        </div>
    </div>
    <!--   Action Buttons    -->
    <?php Pjax::end(); ?>
</div>
