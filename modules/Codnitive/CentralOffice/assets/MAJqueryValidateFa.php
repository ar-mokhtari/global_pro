<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\Codnitive\CentralOffice\assets;

use app\modules\Codnitive\Template\assets\JqueryValidateFa;

/**
 * Main application asset bundle.
 * For farsi Number support
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MAJqueryValidateFa extends JqueryValidateFa
{
    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/Codnitive/Template/views';

    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $css = [
//        'css/style-font.css',
    ];
    public $js = [
        'js/jquery.validate/messages_fa.min.js',
    ];
    public $depends = [

    ];
}
