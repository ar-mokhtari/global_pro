<?php

use kartik\grid\GridView;
use liyunfang\contextmenu\SerialColumn;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Codnitive\OfficeAutomation\models\VwRecieveletterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'صندوق دریافتی';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$script = <<<JS
$(document).off('submit','#vw-recieveletter-index form[data-pjax]');
document.title = '$this->title';
    $('.refreshing').click(function() {
        NProgress.start();
        $('#showLetters_modal_box').empty();
        $('#answerLetters_modal_box').empty();
        $('#referralLetter_modal_box').empty();
        $.pjax.reload({container:'#vw-recieveletter-index',async:false});
        NProgress.done();
    });

JS;
$this->registerJs($script);
?>

<!--//showLetters Modal-->
<!---->
<?php require 'modals/showLetters_modal.html'?>
<!---->
<!--//answerLetters Modal-->
<!---->
<?php require 'modals/answerLetters_modal.html'?>
<!---->
<!--//referralLetter Modal-->
<!---->
<?php require 'modals/referralLetter_modal.html' ?>
<!---->
<div class="vw-recieveletter-index">

    <?php Pjax::begin(['id' => 'vw-recieveletter-index', 'timeout' => false]); ?>
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
                    '{showLetters}<li class=""></li> ' .
                    '{answerLetters}<li class=""></li>' .
                    '{delLetter}<li class=""></li>' .
                    '<li class="divider"></li>' .
                    '{referralLetter}<li class=""></li>',
                'buttons' => [
                    'showLetters' => function ($url, $model) {
                        return '<li data-id = "' . $model->LettersID . '" class="showLetters letter_rightClick">
                        <i class="fa fa-eye" style="margin-right: 5px">
                        </i> نمایش نامه</li>' . PHP_EOL;
                    },
                    'answerLetters' => function ($url, $model) {
                        if ($model->SendLettersReadType == 1) {
                            return '<li data-id = "' . $model->LettersID . '" class="answerLetters letter_rightClick">
                        <i class="fa fa-reply" style="margin-right: 5px">
                        </i> پاسخ به نامه</li>' . PHP_EOL;
                        } else {
                            return '<li
                            style="
                            cursor: not-allowed;
                            direction: rtl;
                            color: #bbbbbb;
                            font-size:1rem" data-id = "' . $model->LettersID . '" class="letter_rightClick">
                            <i class="fa fa-reply" style="margin-right: 5px">
                            </i> پاسخ به نامه</li>' . PHP_EOL;
                        }
                    },
                    'delLetter' => function ($url, $model) {
                        return '<li data-id = "' . $model->LettersID . '" class="delLetter letter_rightClick">
                        <i class="fa fa-remove" style="margin-right: 5px">
                        </i> حذف نامه</li>' . PHP_EOL;
                    },
                    'referralLetter' => function ($url, $model) {
                        if ($model->SendLettersReadType == 1) {
                            return '<li data-id = "' . $model->LettersID . '" class="referralLetter letter_rightClick">
                        <i class="fa fa-mail-forward" style="margin-right: 5px">
                        </i> ارجاع نامه</li>' . PHP_EOL;
                        } else {
                            return '<li data-id = "' . $model->LettersID . '" class="letter_rightClick">
                        <i class="fa fa-mail-forward" style="margin-right: 5px">
                        </i> ارجاع نامه</li>' . PHP_EOL;
                        }
                    }
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
                'vAlign' => 'middle',
                'noWrap' => true,
                'value' => function ($model) {
                    $dateParts = explode(' ', tools()->getFormattedDate($model->LettersCreateDate, 'Y-m-d H:i'));
                    return str_replace('-', '/', '[' . $dateParts[1] . ']' . '   ' . (new \app\modules\Codnitive\Calendar\models\Persian())->getDate($dateParts[0]));
                },
            ],
            [
                'attribute' => 'LettersSubject',
                'width' => '5%',
                'headerOptions' => ['style' => 'text-align:center;'],
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'noWrap' => true,
                'contentOptions' =>
                    [
                        'style' => '
                            max-width: 0.7rem;
                            overflow: hidden;
                            word-wrap: break-word;
                            text-overflow:ellipsis;
                            font-size: 8.5pt!important;
                            '
                        ,
                    ],
            ],
            'SendLettersDate',
            'PersianLettersTypeOfAction',
            'PersianLettersSecurity',
            'PersianLettersAttachmentType',
            'PersianLettersType',
            [
                'attribute' => 'LettersResponseDate',
                'value' => function ($model) {
                    if ($model->LettersResponseDate <> null) {
                        $dateParts = explode(' ', tools()->getFormattedDate($model->LettersResponseDate, 'Y-m-d H:i'));
                        return str_replace('-', '/', (new \app\modules\Codnitive\Calendar\models\Persian())->getDate($dateParts[0]));
                    }
                    return '---';
                },
            ],
            'PersianSendLettersReadType',
            ['attribute' => 'FullNameSender', 'noWrap' => true],
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'فرم صندوق دریافتی',
        ],
        'panelTemplate' => '{panelHeading}{items}{panelFooter}',
        'panelHeadingTemplate' => '
                    {title}<span style="float: left;font-size: 8px;">{export}</span>
                    <hr style="border-color: #ffffff ;box-shadow: 0 0 2px deepskyblue, 0 0 2px lightblue ;margin: 17px 0 0 0">
                    <div class="row">
                    <style>button{margin: 5px 10px 0 0;padding: 4px 5px}</style>
<!--                        <button id="add_draft" style="font-size: 8pt !important;" class="btn btn-default">
                            button name
                        </button> -->
                    ' . $resetFilterButton . '                 
                    </div>
                    ',
        'panelFooterTemplate' =>
            '{pager}{summary}{toggleData}',

    ]); ?>
    <?php
    $showLetterTarget = Yii::$app->urlManager->createUrl(['officeautomation/letters/showletter']);
    $answerLetterTarget = Yii::$app->urlManager->createUrl(['officeautomation/letters/answerletters']);
    $delLetterTarget = Yii::$app->urlManager->createUrl(['officeautomation/letters/delletter']);
    $referralLetterTarget = Yii::$app->urlManager->createUrl(['officeautomation/letters/referralletters']);
    /** @noinspection UnterminatedStatementJS */
    $scripts = /** @lang text */
        <<<JS
    function showLetter(tag) {
        NProgress.start();
        var url = '$showLetterTarget',
        data_id = $(tag).data('key') !== undefined ? $(tag).data('key') : $(tag).data('id') ,
        data = {id:data_id};
        $.post(url,data,function(msg) {
            $.pjax.reload({container:'#vw-recieveletter-index',async:false});
            $('#showLetters_modal').modal('show').find('#showLetters_modal_box').html(msg);
            NProgress.done();
        });
    }
    
    $('.showLetters').click(function() {
    showLetter(this);
    });

    $('#grid_view').find('tbody tr').dblclick(function() {
    showLetter(this);
    });

    $('.answerLetters').click(function() {
        var url = '$answerLetterTarget',
            data_id = $(this).data('key') !== undefined ? $(this).data('key') : $(this).data('id') ,
            data = {id:data_id};
        Swal.fire(before_post
        ).then(result => {
            if (result.value) {
                NProgress.start();
                $.post(url,data,function(msg) {
                    $('#answerLetters_modal').modal('show').find('#answerLetters_modal_box').html(msg);
                });
                NProgress.done();
            } else {}
        });
    });
    
        $('.delLetter').click(function() {
        var url = '$delLetterTarget',
            data_id = data_id = $(this).data('id'),
            data = {'id':data_id};
        Swal.fire(before_del
        ).then(result => {
            if (result.value) {
                NProgress.start();
                $.post(url,data,function(msg) {
                    $.pjax.reload({container:'#vw-recieveletter-index',async:false});
                    var massage = $.parseJSON(msg);
                });
                Swal.fire(after_del);
                NProgress.done();
            } else {}
        });
    });
    
    $('.referralLetter').click(function() {
    var url = '$referralLetterTarget',
        data_id = $(this).data('key') !== undefined ? $(this).data('key') : $(this).data('id') ,
        data = {id:data_id};
    Swal.fire(before_post
        ).then(result => {
            if (result.value) {    
            NProgress.start();
                $.post(url,data,function(msg) {
                    $('#referralLetter_modal').modal('show').find('#referralLetter_modal_box').html(msg);
                    NProgress.done();
                });
            }else{}
        });
    });
    

JS;
    $this->registerJs($scripts);
    ?>

    <?php Pjax::end(); ?>

</div>