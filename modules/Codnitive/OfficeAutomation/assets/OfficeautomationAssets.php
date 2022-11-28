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
class OfficeautomationAssets extends AssetBundle
{
    //public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/OfficeAutomation/views';
    public $css = [
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];

    public $js = [

    ];

    public $depends = [
    ];
}
