<?php

namespace app\modules\Codnitive\Checkout\actions\Ajax;

use Yii;
use yii\base\Action;
use yii\helpers\Json;
use app\modules\Codnitive\Catalog\models\EntityFactory;

class GetPricesAction extends Action
{
    public function run()
    {
        $params = tools()->stripEscapeRequest(app()->getRequest())->post();
        $entity = (new EntityFactory($params['entity_type'], $params['entity_id']))->load();

        $uniqueId = "{$params['entity_type']}_{$params['entity_id']}";
        $wrapper  = "#price_wrapper_$uniqueId";
        $response = [
            ['element' => $wrapper,
                'type'    => 'html',
                'content' => $this->controller->renderPartial(
                    '_price',
                    [
                        'entity'  => $entity,
                        'prices'  => $entity->getPrices(true),
                        'blockId' => "prices_$uniqueId"
                    ]
                )
            ]
        ];

        return Json::encode($response);
    }
}
