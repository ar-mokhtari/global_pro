<?php
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use kartik\helpers\Html;
use liyunfang\contextmenu\SerialColumn;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Codnitive\OfficeAutomation\models\LettersSearch */
/* @var $LettersAttachmentType app\modules\Codnitive\OfficeAutomation\models\LettersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'پیش‌نویس';
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
?>

<?php
$script = <<<JS
document.title = '$this->title';
    $('.add_draft_modal_closed').click(function() {
        $('#add_draft_modal_box').empty();
        $('#edit_draft_modal_box').empty();
        $('#add_attach_modal_box').empty();
        $('#sendDraft_modal_box').empty();
    });
    function search() {
        $('#search_modal').modal('show');
    }
JS;
$this->registerJs($script);
?>
<!--//adding Modal-->
<!---->
<?php require 'modals/add_modal.html' ?>
<!---->
<!--//Edit Modal-->
<!---->
<?php require 'modals/edit_draft_modal.html' ?>
<!---->
<!--//Add Attach Modal-->
<!---->
<?php require 'modals/add_attach_modal.html' ?>
<!---->
<!--//send draft Modal-->
<!---->
<?php require 'modals/sendDraft_modal.html' ?>
<!---->

<div class="letters-index">
    <?php Pjax::begin(['id' => 'letters-index', 'timeout' => 'false']); ?>
    <?php
    Modal::begin([
        'header' => '<h5>'.__('account','range').'</h5>',
        'id' => 'search_modal',
//        'size' => 'modal-lg',
        'class' => 'bg-gray',
        'closeButton'   => [
            'tag'   => 'button',
            'class' => 'pull-left close large',
//            'label' => '<span class="pull-left">×</span>'
        ],
//        'toggleButton'  => ['label' => 'click me'],
        'clientOptions' => ['backdrop' => false, 'keyboard' => true]
    ]);
    ?>
    <?php echo $this->render('_search', ['model' => $searchModel, 'block' => $block,]); ?>
    <?php Modal::end(); ?>
    <?php
    Yii::$app->params['bsVersion'] = '3';
    ?>
    <?php
    $buttonText = __('core', 'Reset Filter');
    $url = '/' . app()->request->pathInfo;
    $resetFilterButton = <<<BTN
        <a style="margin: 0.4rem 0" class="pull-left" href="$url"><span class="btn btn-outline">$buttonText</span></a>

BTN;
    ?>
    <?php
    $buttonSearchText = __('account', 'search');
    $search_url = '/' . app()->request->pathInfo;
    $searchButton = <<<BTN
        <a style="margin: 0.4rem 0" class="pull-left">
            <span onclick="search()" class="btn btn-outline">$buttonSearchText</span>
        </a>

BTN;
    ?>
    <?php
        $send_Button = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => ['LettersNumber', 'LettersCreateDate', 'LettersSubject'],
            'showConfirmAlert' => false,
            'dropdownOptions' => [
                'label' => __('account', 'Send rows'),
                'class' => 'btn btn-outline'
            ],
            'columnSelectorOptions' => [
                'label' => __('account', 'Select Columns'),
                'class' => 'btn btn-outline'
            ],
            'hiddenColumns' => [0, 9], // SerialColumn & ActionColumn
            'disabledColumns' => [1, 2], // ID & Name
        ]);

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
            'showConfirmAlert' => false,
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
        'exportContainer' => ['class' => 'btn-group-sm float-left',],
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
                    '{sendDraft}<li class=""></li> ' .
                    '{updating}<li class=""></li> ' .
                    '{deleting}<li class=""></li> ' .
                    '<li class="divider"></li> ' .
                    '{add_attach_file}<li class=""></li> ' .
                    '{del_attach_file}<li class=""></li> ' .
                    '{download_attach_file}<li class=""></li> ',
                'buttons' => [
                    'sendDraft' => function ($url, $model) {
                        if ($model->LettersType == 0) {
                            return '<li data-id = "' . $model->LettersID . '" class="sendDraft letter_rightClick">
                        <i class="fa fa-edit" style="margin-right: 5px">
                        </i> ارسال پیش‌نویس</li>' . PHP_EOL;
                        } elseif ($model->LettersType == 1 && $model->LettersResponseID != '') {
                            $userinfo = Yii::$app->db->createCommand('CALL oas_SP_InLetterID_OutUserNameCreator(' . $model->LettersResponseID . ')')->queryOne();
                            return '<li data-rid = "' . $model->LettersResponseID . '" data-name="' . $userinfo['_username'] . '" data-id="' . $model->LettersID . '" data-userid="' . $userinfo['_userid'] . '" class="sendAnswer letter_rightClick">
                        <i class="fa fa-edit" style="margin-right: 5px">
                        </i>   ارسال به ' . $userinfo['_username'] . '  </li>' . PHP_EOL;
                        }
                        return false;
                    },
                    'updating' => function ($url, $model) {
                        return '<li data-id = "' . $model->LettersID . '" class="updating letter_rightClick">
                        <i class="fa fa-edit" style="margin-right: 5px">
                        </i> ویرایش پیش‌نویس</li>' . PHP_EOL;
                    },
                    'deleting' => function ($url, $model) {
                        return '<li data-id = "' . $model->LettersID . '" class="deleting letter_rightClick">
                        <i class="fa fa-trash" style="margin-right: 5px">
                        </i> حذف پیش‌نویس</li>' . PHP_EOL;
                    },
                    'add_attach_file' => function ($url, $model) {
                        if ($model->LettersAttachmentType == 0) {
                            return '<li data-id = "' . $model->LettersID . '" class="add_attach_file letter_rightClick">
                            <i class="fa fa-file" style="margin-right: 5px">
                            </i> اضافه کردن پیوست</li>' . PHP_EOL;
                        } else {
                            return '<li
                            style="
                            cursor: not-allowed;
                            direction: rtl;
                            color: #bbbbbb;
                            font-size:1rem" data-id = "' . $model->LettersID . '" class="letter_rightClick">
                            <i class="fa fa-file" style="margin-right: 5px">
                            </i> اضافه کردن پیوست</li>' . PHP_EOL;
                        }
                    },
                    'del_attach_file' => function ($url, $model) {
                        if ($model->LettersAttachmentType == 1) {
                            return '<li data-id = "' . $model->LettersID . '" class="del_attach_file letter_rightClick">
                            <i class="fa fa-close" style="margin-right: 5px">
                            </i> حذف کردن پیوست</li>' . PHP_EOL;
                        } else {
                            return '<li
                            style="
                            cursor: not-allowed;
                            direction: rtl;
                            color: #bbbbbb;
                            font-size:1rem" data-id = "' . $model->LettersID . '" class="letter_rightClick">
                            <i class="fa fa-close" style="margin-right: 5px">
                            </i> حذف کردن پیوست</li>' . PHP_EOL;
                        }
                    },
                    'download_attach_file' => function ($url, $model) {
                        if ($model->LettersAttachmentType == 1) {
                            return '<li data-id = "' . $model->LettersID . '" class="download_attach_file letter_rightClick">
                            <i class="fa fa-download" style="margin-right: 5px">
                            </i> دانلود پیوست</li>' . PHP_EOL;
                        } else {
                            return '<li
                            style="
                            cursor: not-allowed;
                            direction: rtl;
                            color: #bbbbbb;
                            font-size:1rem" data-id = "' . $model->LettersID . '" class="letter_rightClick">
                            <i class="fa fa-download" style="margin-right: 5px">
                            </i> دانلود پیوست</li>' . PHP_EOL;
                        }
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
                'format' => 'raw',
                'value' => function ($model) {
                    return '<div style = "                            
                                            max-width: 350px;
                                            overflow: hidden;
                                            word-wrap: break-word;
                                            text-overflow:ellipsis;
                                            min-height: 13px;
                                            font-size: 8.5pt!important;"
                                title="' . substr($model->LettersSubject, 0, 511) . '">'
                        . $model->LettersSubject
                        . '</div>';
                },
                'noWrap' => true,
                'pageSummary' => true,
                'pageSummaryFunc' => 'f_count',
            ],
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
            'PersianLettersAttachmentType',
            ['attribute' => 'PersianLettersType', 'noWrap' => true],
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
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'فرم پیش‌نویس نامه',
        ],
        'panelTemplate' => '{panelHeading}{items}{panelFooter}',
        'panelHeadingTemplate' => '
                    {title}<span style="float: left;font-size: 8px;">{export}</span>
                    <hr style="border-color: #ffffff ;box-shadow: 0 0 2px deepskyblue, 0 0 2px lightblue ;margin: 17px 0 0 0">
                    <div class="row">
                    <style>button{margin: 5px 5px 0 0;padding: 4px 5px}</style>
                        <button id="add_draft" style="font-size: 8pt !important;" class="btn btn-default">
                            ایجاد پیش‌نویس جدید
                        </button>
                        <div class="group pull-left" title="
                        ' . __('officeautomation', 'Reset Search') . '
                        "> 
                            ' . $resetFilterButton . '  
                        </div>               
                        <div class="group pull-left" title="
                        ' . __('account', 'search') . '
                        "> 
                            ' . $searchButton . '  
                        </div>               
                         <div class=" pull-left" title="
                        ' . __('account', 'search') . '
                        "> 
                             ' . $send_Button . '
                        </div>               
                    </div>
                    ',
        'panelFooterTemplate' =>
            '{pager}{summary}{toggleData}',

    ]); ?>

    <?php
    $Lunch_modal = tools()->getBaseUrl() . tools()->getUrl('officeautomation/letters/lunchmodal');
    $Lunch_modal_sendDraft = tools()->getBaseUrl() . tools()->getUrl('officeautomation/letters/senddraft');
    $Lunch_modal_update = tools()->getBaseUrl() . tools()->getUrl('officeautomation/letters/updating');
    $Lunch_modal_delete = tools()->getBaseUrl() . tools()->getUrl('officeautomation/letters/deleting');
    $Lunch_modal_add_attach_file = tools()->getBaseUrl() . tools()->getUrl('officeautomation/letters/addattachfile');
    $Lunch_modal_del_attach_file = tools()->getBaseUrl() . tools()->getUrl('officeautomation/letters/delattachfile');
    $Lunch_sendAnswer = tools()->getBaseUrl() . tools()->getUrl('officeautomation/letters/sendanswer');

    /** @noinspection UnterminatedStatementJS */
    $script = /** @lang text */
        <<<JS
    $('#add_draft').click(function() {
        var url = '$Lunch_modal',
    ok = true;
    data = {ok:ok};
        NProgress.start();
        $.post(url,data,function(msg) {
            $('#add_draft_modal').modal('show').find('#add_draft_modal_box').html(msg);
        });
        NProgress.done();
    });

    $('.sendDraft').click(function() {
        var url = '$Lunch_modal_sendDraft',
            data_id = $(this).data('id'),
            data = {id:data_id};
        Swal.fire(before_post
        ).then(result => {
            if (result.value) {
                NProgress.start();
                $.post(url,data,function(msg) {
                    $('#sendDraft_modal').modal('show').find('#sendDraft_modal_box').html(msg);
                    // $.pjax.reload({container:'#letters-index',async:false});
                });
                NProgress.done();
            } else {}
        });
    });
    
    function show4Update(tag){
        var url = '$Lunch_modal_update',
        data_id = $(tag).data('key') !== undefined ? $(tag).data('key') : $(tag).data('id') ,
        data = {id:data_id};
        NProgress.start();
        $.post(url,data,function(msg) {
            $('#edit_draft_modal').modal('show').find('#edit_draft_modal_box').html(msg);
            NProgress.done();
        })        
    }
    
    $('.updating').click(function() {
        show4Update(this);
    });
    
    $('#grid_view').find('table tbody tr').dblclick(function() {
        show4Update(this);
    });
    //---
    $(".deleting").click(function() {
        var url = '$Lunch_modal_delete',
            data_id = $(this).data('id'),
            data = {id:data_id};
        Swal.fire(
            before_del
            ).then(result => {
                if (result.value) {
                    NProgress.start();
                    $.post(url,data,function(msg) {
                        $.pjax.reload({container:'#letters-index',async:false});
                            Swal.fire(after_del);
                        NProgress.done();
                    });
                } else {
                }
            });
    });
    
    $('.add_attach_file').click(function() {
        var url = '$Lunch_modal_add_attach_file',
        data_id = $(this).data('id'),
        data = {id:data_id};
        NProgress.start();
        $.post(url,data,function(msg) {
            $('#add_attach_modal').modal('show').find('#add_attach_modal_box').html(msg);
            NProgress.done();
        })
    });
    
    $('.del_attach_file').click(function() {
        var url = '$Lunch_modal_del_attach_file',
        data_id = $(this).data('id'),
        data = {id:data_id};
        Swal.fire(before_del, 
        ).then(result => {
            if (result.value) {
                NProgress.start();
                $.post(url,data,function(msg) {
                    $.pjax.reload({container:'#letters-index',async:false});
                    var massage = $.parseJSON(msg);
                    Swal.fire(after_del);
                    NProgress.done();
                });
            } else {}
        });
    });
    
    $('.download_attach_file').click(function() {
    var id = $(this).data('id');
        NProgress.start();
         MyWindow=window.open('/officeautomation/letters/downloadattach/'+id+'','MyWindow','toolbar=yes,location=yes,directories=yes,status=no,menubar=yes,scrollbars=yes,resizable=yes,width=500,height=500,left=500,top=170');
        NProgress.done();
    });
    
    $('.sendAnswer').click(function() {
        var url = '$Lunch_sendAnswer',
            data_rid = $(this).data('rid'),
            data_id = $(this).data('id'),
            data_name = $(this).data('name'),
            data_userid = $(this).data('userid'),
            data = {rid:data_rid,id:data_id,userid:data_userid};
        Swal.fire(before_post, 
        ).then(result => {
            if (result.value) {
                NProgress.start();
                $.post(url,data,function(msg) {
                    $.pjax.reload({container:'#letters-index',async:false});
                        Swal.fire(after_post);
                    NProgress.done();
                });
            } else {}
        });        
    });

JS;
    $this->registerJs($script);
    ?>
    <?php Pjax::end(); ?>


</div>