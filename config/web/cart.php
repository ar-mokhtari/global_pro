<?php

$config['components']['cart'] = [
    // 'class'             => 'devanych\cart\Cart',
    // 'storageClass'      => 'devanych\cart\storage\DbSessionStorage',
    // 'calculatorClass'   => 'devanych\cart\calculators\SimpleCalculator',
    'class'             => 'app\modules\Codnitive\Checkout\models\Cart',
    'storageClass'      => 'app\modules\Codnitive\Checkout\models\Storage\DbSessionStorage',
    'calculatorClass'   => 'app\modules\Codnitive\Checkout\models\Calculators\SimpleCalculator',
    'params' => [
        // 'key'               => 'cart',
        // 'expire'            => 604800,
        'expire'            => 1209600,
        'productClass'      => 'app\modules\Codnitive\Catalog\models\Product',
        // 'productFieldId'    => 'id',
        // 'productFieldPrice' => 'price',
    ],
];
// $config['modules']['cart'] = [
//     'classMap' => [
//         'devanych\cart\CartItem' => '@app/modules/Codnitive/Checkout/models/CartItem.php',
//     ],
// ];
