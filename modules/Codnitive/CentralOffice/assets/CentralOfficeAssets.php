<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\Codnitive\CentralOffice\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CentralOfficeAssets extends AssetBundle
{
    //public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/CentralOffice/views';
    public $css = [
        'css/bootstrap-select.css',
////        'css/site_OLD.css',
//        'css/sweetalert.css',
        'css/nprogress.css',
//        'css/admin.css',
//        'css/bootstrap-dialog.min.css',
////        'css/dropzone.css',
//        'css/jspc-royal_blue.css',
//        'css/bootstrap.css',
//        'css/bilit.css',
//        'css/bootstrap-rtl.min.css',
        "dist/css/bootstrap-theme.css",
//        "dist/css/persian-datepicker-0.4.5.min",
//        "bower_components/font-awesome/css/font-awesome.min.css",
//        "bower_components/Ionicons/css/ionicons.min.css",
        "dist/css/skins/_all-skins.min.css",
//        "bower_components/morris.js/morris.css",
//        "bower_components/jvectormap/jquery-jvectormap.css",

        //-----------------
        /*glyphicons *** IMPORTANT*/
        "bower_components/bootstrap/dist/css/bootstrap.css",
        //-----------------

//        "bower_components/bootstrap-daterangepicker/daterangepicker.css",
//        "plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css,",
        //-----------------
//        'css/bootstrap-rtl.min.css',
        'css/main.css',
//        'css/site.css', //font IRANSansWeb
        'css/font-awesome.min.css',
//        'css/font-awesome-rtl.css',
        //-----------------
        "dist/css/rtl.css",
        "dist/css/AdminLTE.css",
        //-----------------
//        'css/adminlte.css',
        'css/custom.css',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];

    public $js = [
        'js/sweetalert2.all.min.js',
        'js/nprogress.js',
        'js/global_alert.js',
        'js/bootstrap-select.js',
//        "bower_components/raphael/raphael.min.js",
//        "bower_components/morris.js/morris.min.js",
//        "bower_components/jquery-sparkline/dist/jquery.sparkline.min.js",
//        "plugins/jvectormap/jquery-jvectormap-1.2.2.min.js",
//        "plugins/jvectormap/jquery-jvectormap-world-mill-en.js",
//        "bower_components/jquery-knob/dist/jquery.knob.min.js",
//        "bower_components/moment/min/moment.min.js",
//        "bower_components/bootstrap-daterangepicker/daterangepicker.js",
//        "bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js",
//        "plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js",
//        "bower_components/jquery-slimscroll/jquery.slimscroll.min.js",
//        "bower_components/fastclick/lib/fastclick.js",
//        "dist/js/pages/dashboard.js",
        "dist/js/demo.js",
        "dist/js/adminlte.min.js",
        "bower_components/bootstrap/dist/js/bootstrap.min.js",
        "bower_components/Chart/Chart.js",
        'js/main.js',
        'ckeditor/ckeditor.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
