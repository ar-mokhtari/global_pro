<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\Codnitive\Template\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class OwlCarousel extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Template/views';
    public $css = [
        'css/owl.carousel.css',
        'css/owl.theme.default.css',
        'css/animate.css',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        'js/owl.carousel.js',
        // 'js/easing.js',
    ];
    public $depends = [
        'app\modules\Codnitive\Template\assets\Main',
        'app\modules\Codnitive\Template\assets\Easing',
    ];
}
