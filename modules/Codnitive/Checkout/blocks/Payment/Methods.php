<?php 

namespace app\modules\Codnitive\Checkout\blocks\Payment;

use app\modules\Codnitive\Core\Module as CoreModule;
use app\modules\Codnitive\Core\blocks\Template;

class Methods extends Template
{
    public function getMethods()
    {
        CoreModule::loadModules(app()->params['modules']['payments']);
        $payments = app()->params['payments'];
        ksort($payments);
        return $payments;
    }
}
