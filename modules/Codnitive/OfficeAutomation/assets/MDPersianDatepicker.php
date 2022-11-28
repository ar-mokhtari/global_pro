<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\Codnitive\OfficeAutomation\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MDPersianDatepicker extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Template/views';
    public $css = [
        'css/jquery.md.bootstrap.datetimepicker.style.css',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        'js/jquery.md.bootstrap.datetimepicker-edited.js',
        'js/popper.min.js',
        'js/bootstrap.min.js',
        'js/jquery.validate.min.js',
        'js/MutationObserver.js',
        'js/codnitive.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
