<?php

namespace app\modules\Codnitive\Wallet\assets;

use yii\web\AssetBundle;

/**
 * Wallet module asset bundle.
 *
 * @author Omid <hbarza@gmail.com>
 * @since 2.0
 */
class Wallet extends AssetBundle
{
    // public $basePath = '@webroot';
    public $baseUrl    = '@web';
    public $sourcePath = '@app/modules/Codnitive/Wallet/views';
    // public $css = [
    //     // 'https://fonts.googleapis.com/css?family=Montserrat:400,700%7CVarela+Round',
    //     'css/wallet.css',
    //     // ['css/print.css', 'media' => 'print'],
    // ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $js = [
        'js/wallet.js',
    ];
    public $depends = [
        'app\modules\Codnitive\Template\assets\Main',
    ];
}
