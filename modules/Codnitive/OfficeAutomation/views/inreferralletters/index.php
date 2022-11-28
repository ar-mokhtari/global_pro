<?php

use kartik\grid\GridView;
use liyunfang\contextmenu\SerialColumn;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Codnitive\OfficeAutomation\models\InReferrallettersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'نامه های ارجاعی-وارده';
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
?>
<?php
$script = <<<JS
document.title = '$this->title';
    $('.referral_modal_closed').click(function() {
        $('#showReferral_modal_box').empty();
    });
JS;
$this->registerJs($script);
?>
<?php require 'modals/show.phtml' ?>
<?php require 'modals/referal.phtml' ?>

<div class="vw-referralletters-index">
    <?php Pjax::begin(['id' => 'vw-inrecieveletter-index', 'timeout' => false]); ?>
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
                    '{show}<li class=""></li> ' .
                    '<li class="divider"></li> ' .
                    '{download_attach_file}<li class=""></li> ' .
                    '{referral}<li class=""></li> ',
                'buttons' => [
                    'show' => function ($url, $model) {
                        return '<li 
                        style="
                        cursor: pointer;
                        direction: rtl;
                        font-size:11px" data-refid = "' . $model->ReferralLettersID . '" class="show letter_rightClick">
                        <i class="fa fa-eye" style="margin-right: 5px">
                        </i> مشاهده نامه</li>' . PHP_EOL;
                    },
                    'download_attach_file' => function ($url, $model) {
                        if ($model->LettersAttachmentType == 1) {
                            return '<li 
                            style="
                            cursor: pointer;
                            direction: rtl;
                            font-size:11px" data-refid = "' . $model->LettersID . '" class="download_attach_file letter_rightClick">
                            <i class="fa fa-download" style="margin-right: 5px">
                            </i> دانلود پیوست</li>' . PHP_EOL;
                        } else {
                            return '<li
                            style="
                            cursor: not-allowed;
                            direction: rtl;
                            color: #bbbbbb;
                            font-size:8px" data-id = "' . $model->LettersID . '" class="letter_rightClick">
                            <i class="fa fa-download" style="margin-right: 5px">
                            </i> دانلود پیوست</li>' . PHP_EOL;
                        }
                    },
                    'referral' => function ($url, $model) {
                        return '<li 
                        style="
                        cursor: pointer;
                        direction: rtl;
                        font-size:11px" data-id = "' . $model->LettersID . '" class="referral letter_rightClick">
                        <i class="fa fa-share-square" style="margin-right: 5px">
                        </i> ارجاع نامه</li>' . PHP_EOL;
                    },

                ],
            ],
            'LettersNumber',
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
            'ReferralLettersDescription',
            'FullCreator',
            [
                'attribute' => 'LettersCreateDate',
                'vAlign' => 'middle',
                'noWrap' => true,
                'value' => function ($model) {
                    $dateParts = explode(' ', tools()->getFormattedDate($model->LettersCreateDate, 'Y-m-d H:i'));
                    return str_replace('-', '/', '[' . $dateParts[1] . ']' . '   ' . (new \app\modules\Codnitive\Calendar\models\Persian())->getDate($dateParts[0]));
                },
            ],
            'FullNameSender',
            [
                'attribute' => 'ReferralLettersDate',
                'vAlign' => 'middle',
                'noWrap' => true,
                'value' => function ($model) {
                    switch ($model->ReferralLettersDate) {
                        case null :
                            return '---';
                        default :
                            $dateParts = explode(' ', tools()->getFormattedDate($model->ReferralLettersDate, 'Y-m-d H:i'));
                            return str_replace('-', '/', '[' . $dateParts[1] . ']' . '   ' . (new \app\modules\Codnitive\Calendar\models\Persian())->getDate($dateParts[0]));
                    }
                },
            ],
        ],

        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'فرم ارجاعی گرفته شده',
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
    $showTarget = Yii::$app->urlManager->createUrl('officeautomation/reports/showinreferralletters');
    $referralTarget = Yii::$app->urlManager->createUrl('officeautomation/reports/addreferal');
    $script_rightClick = <<<JS
    function show(tag) {
        NProgress.start();
        var url = '$showTarget',
            refid = $(tag).data('refid') === undefined ? $(tag).data('key') : $(tag).data('refid'),
            data = {'refid':refid};
        $.post(url,data,function(msg) {
            $('#showReferral_modal').modal('show').find('#showReferral_modal_box').html(msg);
            NProgress.done();
        });      
    }
    $('.show').click(function() {
        show(this);
    });
    $('#grid_view').find('tbody tr').dblclick(function() {
      show(this);
    });
    
    $('.download_attach_file').click(function() {
    var id = $(this).data('refid');
        NProgress.start();
         MyWindow=window.open('/OfficeAutomation/inreferralletters/download-attach?id='+id+'','MyWindow','toolbar=yes,location=yes,directories=yes,status=no,menubar=yes,scrollbars=yes,resizable=yes,width=500,height=500,left=500,top=170');
        NProgress.done();
    });
    
    $('.referral').click(function() {
        var url = '$referralTarget',
            data_id = $(this).data('id'),
            data = {'id':data_id};
        $.post(url,data,function(msg) {
            $('#Referral_modal').modal('show').find('#Referral_modal_box').html(msg);
        });
    });
JS;
    $this->registerJs($script_rightClick);
    ?>

    <?php Pjax::end(); ?>

</div>
