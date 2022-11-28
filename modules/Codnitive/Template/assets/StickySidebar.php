<?php
namespace app\modules\Codnitive\Template\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class StickySidebar extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Template/views';
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        'js/ResizeSensor.js',
        'js/jquery.sticky-sidebar.min.js',
    ];
    public $depends = [
        'app\modules\Codnitive\Template\assets\Main',
    ];
}
