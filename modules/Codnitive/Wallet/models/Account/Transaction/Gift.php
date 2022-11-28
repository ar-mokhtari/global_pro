<?php

namespace app\modules\Codnitive\Wallet\models\Account\Transaction;

class Gift
{
    /**
     * is gift credit enabled or not
     */
    protected $_enabled = true;

    /**
     * how to add credit git
     * possible values: fixed | percentage
     */
    protected $_giftType   = 'percentage';

    /**
     * how much credit gift should add to bought credit
     */
    protected $_giftAmount = 10;

    public function getGiftCreditAmount(float $chargedAmount): float
    {
        if (!$this->_enabled) return 0.0;
        return $this->_giftType == 'percentage' 
            ? (float) ($this->_giftAmount * $chargedAmount) / 100
            : (float) $this->_giftAmount;
    }
}
