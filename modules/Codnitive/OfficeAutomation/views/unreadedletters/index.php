<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\Codnitive\OfficeAutomation\models\UnreadedlettersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'صندوق دریافتی - خوانده نشده';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$script = <<<JS
document.title = '$this->title';
JS;
$this->registerJs($script);
?>

<div class="vw-recieveletter-index">
    <?php Pjax::begin(); ?>
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
                'class' => \liyunfang\contextmenu\SerialColumn::className(),
                'contextMenu' => true,
            ],
            'LettersID',
            'LettersNumber',
            [
                'attribute' => 'SendLettersDate',
                'vAlign' => 'middle',
                'noWrap' => true,
                'value' => function ($model) {
                    switch ($model->SendLettersDate) {
                        case null:
                        case '0000-00-00 00:00:00' :
                            return '---';
                        default :
                            $dateParts = explode(' ', tools()->getFormattedDate($model->SendLettersDate, 'Y-m-d H:i'));
                            return str_replace('-', '/', '[' . $dateParts[1] . ']' . '   ' . (new \app\modules\Codnitive\Calendar\models\Persian())->getDate($dateParts[0]));
                    }
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
            [
                'attribute' => 'FullNameSender',
                'headerOptions' => ['style' => 'text-align:center;'],
                'hAlign' => 'right',
                'vAlign' => 'middle',
                'noWrap' => true,
                'contentOptions' =>
                    [
                        'style' => '
                            max-width: 1rem;
                            overflow: hidden;
                            word-wrap: break-word;
                            text-overflow:ellipsis;
                            font-size: 8.5pt!important;
                            '
                        ,
                    ],
            ],
            'PersianLettersTypeOfAction',
            'PersianLettersSecurity',
            'PersianLettersFollowType',
            'PersianLettersAttachmentType',
            'PersianLettersType',
            'PersianLettersResponseType',
        ],

        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'فرم نامه‌های خوانده‌نشده',
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
    <?php Pjax::end(); ?>

</div>
