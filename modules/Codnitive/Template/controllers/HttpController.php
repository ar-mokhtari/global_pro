<?php

namespace app\modules\Codnitive\Template\controllers;

// use yii\helpers\Json;
use app\modules\Codnitive\Template\controllers\PageController;
// use app\modules\Codnitive\Core\Module as CoreModule;

class HttpController extends PageController
{
    protected $_baseActionsPath = 'app\modules\Codnitive\Template\actions';
    protected $_actions = [
        'error' => ['get', 'post'],
    ];

    /**
     * @link https://www.yiiframework.com/doc/guide/2.0/en/security-authorization
     * 
     * ?: matches a guest user (not authenticated yet)
     * @: matches an authenticated user
     */
    protected $_roles = [
        'error' => ['?', '@'], 
    ];
}
