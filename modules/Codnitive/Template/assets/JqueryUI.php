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
class JqueryUI extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Template/views';
    public $css = [
        'jqueryui/jquery-ui.min.css',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        'jqueryui/jquery-ui.min.js',
    ];
    public $depends = [
        'app\modules\Codnitive\Template\assets\Main',
    ];
}
