<?php 

namespace app\modules\Codnitive\Wallet\models\Admin;

use app\modules\Codnitive\Core\models\DynamicModel;
use app\modules\Codnitive\Wallet\models\Transaction;
use app\modules\Codnitive\Account\models\User;

class EditForm extends DynamicModel
{
    public $id;
    protected $_oldCreditAmount;

    protected $_module = 'wallet';
    protected $_attributes = ['user_id', 'credit_amount', 'change_amount', 'description'];
    protected $_rules = [
        'required' => ['user_id'],
        'integer'  => ['user_id', 'credit_amount', 'change_amount'], 
        'string'   => ['description']
    ];
    protected $_labels = [
        'user_id'  => 'User',
        'credit_amount'  => 'Credit Amount',
        'change_amount'  => 'Change Amount',
        'description'  => 'Description',
    ];

    public function saveCredit(): void
    {
        $user = $this->_getUser();
        $this->_oldCreditAmount = $user->credit_amount;
        $user->setAttribute('credit_amount', $this->_calcCredit());
        if ($user->save()) {
            $this->_saveTransactionsInfo();
        }
    }

    protected function _saveTransactionsInfo()
    {
        $newCredit    = floatval($this->credit_amount);
        $oldCredit    = floatval($this->_oldCreditAmount);
        $changeAmount = floatval($this->change_amount);
        $userId       = $this->user_id;
        $date         = tools()->getNow();
        $adminName    = tools()->getUser()->identity->fullname;

        if ($newCredit != $oldCredit) {
            $this->_saveTransaction([
                'user_id' => $userId,
                'change_amount' => $newCredit - $oldCredit,
                'new_amount' => $newCredit,
                'description' => __('wallet', 'User credit changed from {old_amount} to {new_amount} by {admin} <br>{description}', [
                    'old_amount' => $oldCredit,
                    'new_amount' => $newCredit,
                    'admin' => $adminName,
                    'description' => $this->description
                ]),
                'trasaction_date' => $date
            ]);
        }
        if ($changeAmount) {
            $this->_saveTransaction([
                'user_id' => $userId,
                'change_amount' => $changeAmount,
                'new_amount' => $newCredit + $changeAmount,
                'description' => __('wallet', 'Credit change amount {change_amount} by {admin} <br>{description}', [
                    'change_amount' => $changeAmount,
                    'admin' => $adminName,
                    'description' => $this->description
                ]),
                'trasaction_date' => $date
            ]);
        }
    }

    protected function _saveTransaction(array $data)
    {
        (new Transaction($data))->save();
    }

    protected function _getUser()
    {
        return (new User)->loadOne(intval($this->user_id));
    }

    protected function _calcCredit()
    {
        return floatval($this->credit_amount) + floatval($this->change_amount);
    }
}
