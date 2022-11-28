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
class SimpleError extends AssetBundle
{
    // public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Template/views';
    public $css = [
        'https://fonts.googleapis.com/css?family=Cabin:400,700',
        'https://fonts.googleapis.com/css?family=Montserrat:900',
        'css/simple_error.css',
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
        'condition' => 'lt IE 9'
    ];
    public $js = [
        'https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js',
        'https://oss.maxcdn.com/respond/1.4.2/respond.min.js',
    ];
    // public $depends = [
    //     'yii\web\YiiAsset',
    //     'yii\bootstrap\BootstrapAsset',
    // ];
}
