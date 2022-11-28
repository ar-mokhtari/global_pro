<?php

use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Codnitive\OfficeAutomation\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'کاربران';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    body {
        user-select: none;
    }

    .modal-lg {
        min-width: 85vw !important;
    }

    #grid_view table thead th {
        background-color: #d9edf7;
    }

    #grid_view table tbody tr {
        cursor: pointer;
    }

    #grid_view table tbody tr:hover {
        background: #f0f1ff;
    }

    .letter_rightClick:hover {
        background: #c4e3f3;
    }

    .form-control {
        width: 100%;
    }

    #grid_view-container {
        overflow: visible;
    }

</style>

<?php
$script = <<<JS
    $('.closing').click(function() {
        $('#addSign_modal_box').empty();

    });
JS;
$this->registerJs($script);
?>
<!--//adding Modal-->
<!---->
<div role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" id="addSign_modal"
     data-backdrop="static"
     data-keyboard="true" class="fade modal fade-scale" role="dialog" tabindex="-1"
     style="display: none; padding-right: 19px;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header " style="background-color: whitesmoke">
                <button type="button"
                        class="close cl_search closing" style="float: right;opacity: 1"
                        data-dismiss="modal"
                        aria-hidden="true"><i style="opacity: 1;font-size: 25px;color: #e83e8c"
                                              class="fa fa-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="addSign_modal_box">
                </div>
            </div>
        </div>
    </div>
</div>
<!---->
<div class="users-index">

    <?=
    $this->render('create', [
        'model' => $model,
    ])
    ?>

    <?php Pjax::begin(['ID' => 'users-index', 'timeout' => false]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= /** @noinspection PhpUnhandledExceptionInspection */
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'hover' => true,
        'responsive' => true,
        'resizableColumns' => false,
        'rowOptions' => function ($model, $key, $index, $gird) {
            $contextMenuId = $gird->columns[0]->contextMenuId;
            return ['data' => ['toggle' => 'context', 'target' => "#" . $contextMenuId]];
        },
        'options' => [
            'id' => 'grid_view',
        ],
        'columns' => [
            [
                'class' => \liyunfang\contextmenu\SerialColumn::className(),
                'contextMenu' => true,
                'template' =>
                    '{addSign}<li class=""></li> '.
                    '{delSign}<li class=""></li> ',
                'buttons' => [
//                    'addSign' => function ($url, $model) {
//                        if ($model->UserSign == '') {
//                            return '<li
//                        style="
//                        cursor: pointer;
//                        direction: rtl;
//                        font-size:11px" data-uid = "' . $model->UserID . '" class="addSign letter_rightClick">
//                        <i class="fa fa-plus" style="margin-right: 5px">
//                        </i> اضافه نمودن امضاء</li>' . PHP_EOL;
//                        } else {
//                            return '<li
//                        style="
//                        cursor: not-allowed;
//                        direction: rtl;
//                        color: #bbbbbb;
//                        font-size:11px" class="letter_rightClick">
//                        <i class="fa fa-plus" style="margin-right: 5px">
//                        </i> حذف نمودن امضاء  </li>' . PHP_EOL;
//                        }
//                    },
//                    'delSign' => function ($url, $model) {
//                        if ($model->UserSign != '') {
//                            return '<li
//                        style="
//                        cursor: pointer;
//                        direction: rtl;
//                        font-size:11px" data-uid = "' . $model->UserID . '" class="delSign letter_rightClick">
//                        <i class="fa fa-remove" style="margin-right: 5px">
//                        </i> حذف نمودن امضاء</li>' . PHP_EOL;
//                        } else {
//                            return '<li
//                        style="
//                        cursor: not-allowed;
//                        direction: rtl;
//                        color: #bbbbbb;
//                        font-size:11px" class="letter_rightClick">
//                        <i class="fa fa-remove" style="margin-right: 5px">
//                        </i> حذف نمودن امضاء  </li>' . PHP_EOL;
//                        }
//                    },
                ],
            ],
            'id',
            'username',
            'fullname',
            'password_hash',
//            [
//                'label'=>'امضاء',
//                'attribute'=>'UserSign',
//                'format'=>'raw',
//                'value'=>function($model)
//                {
//                    if($model->UserSign!='')
//                    {
//                        $Src = Yii::$app->request->baseUrl.'/web/users_picture/'.$model->UserSign;
//                        return '<img src="'.$Src.'" style="width: 75px;height: 75px" >';
//                    }
//                }
//            ],
//            ['class' => 'yii\grid\ActionColumn','header'=>'عملیات','template'=>'{update}'],
        ],
    ]); ?>
    <?php
    $addSignTarget = Yii::$app->urlManager->createUrl('users/add-sign');
    $script = <<<JS
    $('.addSign').click(function() {
        var url = '$addSignTarget',
            data_uid = $(this).data('uid'),
            data = {'uid':data_uid};
        $.post(url,data,function(msg) {
            NProgress.start();
            $('#addSign_modal').modal('show').find('#addSign_modal_box').html(msg);
            NProgress.done();
        });
    });
JS;
    $this->registerJs($script);
    ?>

    <?php Pjax::end(); ?>

</div>
