<?php

namespace app\modules\Codnitive\Checkout\exceptions;

class InvalidPaymentMethodException extends \yii\base\Exception
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Invalid Payment Method';
    }
}
