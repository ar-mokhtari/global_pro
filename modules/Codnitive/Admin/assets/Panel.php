<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\Codnitive\Admin\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Panel extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Admin/views';
    public $css = [
        // 'css/dataTables.bootstrap4.css',
        // 'css/sb-admin.css',
        'css/sb-admin-rtl.css',
        // 'css/zebra_datepicker.min.css',
        // 'css/bootstrap-clockpicker.min.css',
        'css/custom.css',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        // 'js/jquery.easing.min.js',
        // 'js/jquery.dataTables.js',
        // 'js/dataTables.bootstrap4.js',
        'js/sb-admin.min.js',
        // 'js/sb-admin-datatables.min.js',
        // 'js/sb-admin-charts.min.js',
        // 'js/zebra_datepicker.min.js',
        // 'js/bootstrap-clockpicker.min.js',
        // 'http://cdn.ckeditor.com/4.7.3/standard/ckeditor.js', // loads standard editor
        // 'js/tixox.js',
        // 'js/app.js',
    ];
    public $depends = [
        'app\modules\Codnitive\Account\assets\Panel',
        // 'kartik\file\FileInputAsset',
        // 'kartik\file\FileInputThemeAsset'
    ];
}
