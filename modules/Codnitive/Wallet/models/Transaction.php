<?php

namespace app\modules\Codnitive\Wallet\models;

use app\modules\Codnitive\Core\models\ActiveRecord;
use app\modules\Codnitive\Wallet\models\Account\Transaction\Gift;
use app\modules\Codnitive\Checkout\models\TransactionInterface;
use app\modules\Codnitive\Sales\models\Order;
use app\modules\Codnitive\Account\models\User;

class Transaction extends ActiveRecord implements TransactionInterface
{
    public const TRANSACTION_SUFFIX = 'WLT-';

    protected $_parentObjectField = 'user_id';
    protected $_onlinePartTransaction;
    protected $_transactionsCollection = [];

    private $user;

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{user_wallet_credit_transaction}}';
    }

    public function rules()
    {
        $rules = [
            [['user_id', 'change_amount', 'new_amount', 'description', 'trasaction_date', 'order_id', 'payment_method', 'payment_id'], 'safe'],
            [['user_id', 'change_amount', 'trasaction_date'], 'required']
        ];
        return $rules;
    }

    public function setUserId(int $userId): self
    {
        $this->_parentObjectId = $userId;
        return $this;
    }

    public function setUser(\dektrium\user\models\User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getUser(): User
    {
        if (!$this->user) {
            $this->user = (new User)->loadOne((int) $this->_parentObjectId);
        }
        return $this->user;
    }

    public function loadPendingTransaction(int $transactionId): self
    {
        $object = $this->loadOne(0, [
            'id' => $transactionId,
            'new_amount' => null, 
            'user_id' => $this->_parentObjectId
        ]);
        return $object;
    }

    public function addChargeRequest(float $amount, string $gateway): self
    {
        $data = [
            'user_id' => $this->_parentObjectId,
            'change_amount' => $amount,
            'description' => __('wallet', 'Charge request added'),
            'trasaction_date' => $this->_getTimestamp()
        ];
        $this->setAttributes($data);
        $this->save();
        return $this;
    }

    public function addCredit(float $amount, string $description = 'Credit added to account'): bool
    {
        $currentCredit = (float) $this->getUser()->credit_amount;
        $newCreditAmount = $currentCredit + $amount;
        $this->_updateUserCredit($newCreditAmount);

        $data = [
            'user_id' => $this->_parentObjectId,
            'change_amount' => $amount,
            'new_amount' => $newCreditAmount,
            'description' => $description,
            'trasaction_date' => $this->_getTimestamp()
        ];
        $this->setAttributes($data);
        return $this->save();

        // return $newCreditAmount;
    }

    public function minusCredit(float $amount): bool
    {
        return $this->addCredit(-1 * abs($amount));
    }

    public function addCharge(): self
    {
        $currentCredit = (float) $this->getUser()->credit_amount;
        $giftCredit = (new Gift)->getGiftCreditAmount($this->change_amount);
        $newCreditAmount = $currentCredit + $this->change_amount + $giftCredit;
        $this->_updateUserCredit($newCreditAmount);
        $this->new_amount = $newCreditAmount;
        $this->description = __('wallet', 'Success Credit Charge');
        $this->save();
        return $this;
    }

    public function useCredit(float $requestedCreditAmount, Order $order): self
    {
        $referenceNumber = $order->getOrderNumber();
        $currentCredit   = (float) $this->getUser()->credit_amount;
        $newCreditAmount = $currentCredit - $requestedCreditAmount;
        $this->_updateUserCredit($newCreditAmount);
        // app()->getModule('wallet');
        $data = [
            'user_id' => $this->_parentObjectId,
            'change_amount' => -$requestedCreditAmount,
            'new_amount' => $newCreditAmount,
            'description' => __('wallet', 'Buying in order# {order_number}', ['order_number' => $referenceNumber]),
            'trasaction_date' => $this->_getTimestamp(),
            'order_id' => $order->id
        ];
        $this->setAttributes($data);
        $this->save();
        return $this;
    }

    public function revertCredit(int $transactionId, string $orderNumber): self
    {
        $transaction = $this->loadOne($transactionId);
        $currentCredit = (float) $this->getUser()->credit_amount;
        $newCreditAmount = $currentCredit - $transaction->change_amount;
        $this->_updateUserCredit($newCreditAmount);

        $data = [
            'user_id' => $transaction->user_id,
            'change_amount' => -$transaction->change_amount,
            'new_amount' => $newCreditAmount,
            'description' => __('wallet', 'Revert transaction order# {order_number}', ['order_number' => $orderNumber]),
            'trasaction_date' => $this->_getTimestamp()
        ];
        $this->setAttributes($data);
        $this->save();
        return $this;
    }

    public function refundCredit(float $amount, string $orderNumber, string $ticketId): bool
    {
        return $this->addCredit($amount,  __('template', 'Refund for ticket ID {ticket_id} from order# {order_number}', 
            ['ticket_id' => $ticketId, 'order_number' => $orderNumber]
        ));
    }

    private function _updateUserCredit(float $newCreditAmount): bool
    {
        $this->getUser()->credit_amount = $newCreditAmount;
        return $this->getUser()->save();
        // $this->getUser()->save();
    }

    protected function _getTimestamp(): string
    {
        return (new \DateTime())->setTimezone(new \DateTimeZone(app()->timeZone))->format('Y-m-d H:i:s');
    }

    public function loadByOrderId(int $orderId): self
    {
        if (empty($orderId)) {
            return $this;
        }
        $self = $this->loadOne(0, ['order_id' => $orderId]);
        $self->loadOnlineTransaction();
        return $self;
    }

    public function loadAllOrderTransactions(int $orderId): self
    {
        if (empty($orderId)) {
            return $this;
        }
        $collection = $this->prepareCollection();
        $collection->andWhere(['order_id' => $orderId]);
        $this->_transactionsCollection = $collection->all();
        return $this;
    }

    public function getTransactionsCollection(): array
    {
        return $this->_transactionsCollection;
    }

    public function loadTransaction(string $transNum, int $orderId)
    {
        if (empty($transNum)) {
            return $this;
        }
        $row = $this->loadOne(intval($transNum));
        if (!empty($row['order_id']) && $row['order_id'] !== $orderId) {
            return false;
        }
        return $row;
    }
    
    public function loadOnlineTransaction(): self
    {
        $onlinePeyment   = $this->payment_method;
        $onlinePeymentId = $this->payment_id;
        if (!empty($onlinePeyment) && !empty($onlinePeymentId)) {
            $object = getObject("app\modules\Codnitive\\$onlinePeyment\models\Transaction");
            $this->_onlinePartTransaction = $object->loadOne($onlinePeymentId);
        }
        return $this;
    }

    public function getOnlineTransaction()
    {
        return $this->_onlinePartTransaction;
    }

    public function getTransactionTemplate(): string
    {
        return '@app/modules/Codnitive/Wallet/views/templates/transaction.phtml';
    }

    public function getTransactionNumber(): string
    {
        return self::TRANSACTION_SUFFIX . $this->id;
    }

}
