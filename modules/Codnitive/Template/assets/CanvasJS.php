<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\Codnitive\Template\assets;

use yii\web\AssetBundle;

/**
 * jQuery Lazy asset bundle.
 * @link http://jquery.eisbehr.de/lazy/
 * @link https://github.com/eisbehr-/jquery.lazy
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CanvasJS extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Template/views';
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $css = [
        'fonts/font-roboto.css',
    ];
    public $js = [
        // 'js/jquery.canvasjs.min.js',
        'js/tether.min.js',
        'js/canvasjs.min.js',
        'js/jquery.scrollspeed.min.js',
        'js/jquery.inview.min.js',
    ];
    public $depends = [
        'app\modules\Codnitive\Template\assets\JqueryUI',
    ];
}
