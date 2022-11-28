<?php

namespace app\modules\Codnitive\Wallet\models\Account\Transaction;

use app\modules\Codnitive\Core\models\Grid\GridAbstract;
use app\modules\Codnitive\Calendar\models\Persian;

class Grid extends GridAbstract
{
    protected $_modelClass      = '\app\modules\Codnitive\Wallet\models\Transaction';
    protected $_searchModel     = '\app\modules\Codnitive\Wallet\models\Account\Transaction\Grid\Filter';
    protected $_actionsTemplate = '';
    
    public function __construct()
    {
        parent::__construct();
        $this->_columns = ['id', 'change_amount', 'new_amount', 'trasaction_date', 'description'];
        $this->_sortAttributes = ['id', 'change_amount', 'new_amount', 'trasaction_date'];
    }

    protected function _prepareDataCollection($columns = [])
    {
        $collection = parent::_prepareDataCollection($columns);
        return $collection->andWhere(['user_id' => tools()->getUser()->id]);
    }

    protected function _prepareColumnsFormat()
    {
        return [
            [
                'attribute' => 'id',
                'label' => __('wallet', 'Transaction ID'),
                'value' => function ($model) {
                    return $model->getTransactionNumber();
                },
            ],
            [
                'attribute' => 'change_amount',
                'label' => __('wallet', 'Change Amount'),
                'contentOptions' => ['class' => 'force-text-right'],
                'format' => 'html',
                'value' => function ($model) {
                    return tools()->formatRial((float) $model->change_amount);
                },
            ],
            [
                'attribute' => 'new_amount',
                'label' => __('wallet', 'New Credit Amount'),
                'contentOptions' => ['class' => 'force-text-right'],
                'format' => 'html',
                'value' => function ($model) {
                    if (!is_null($model->new_amount)) {
                        return tools()->formatRial((float) $model->new_amount);
                    }
                },
            ],
            [
                'attribute' => 'trasaction_date',
                'label' => __('wallet', 'Transaction Date'),
                'format' => 'html',
                'value' => function ($model) {
                    $dateParts = explode(' ', tools()->getFormattedDate($model->trasaction_date, 'Y-m-d H:i'));
                    return str_replace('-', '/', (new Persian)->getDate($dateParts[0])) . '&nbsp;' . $dateParts[1];
                }
            ],
            [
                'attribute' => 'description',
                'label' => __('wallet', 'Description'),
                'format' => 'html',
            ],
        ];
    }

    protected function _getActionUrls($action, $model, $key, $index)
    {
        return;
    }
}
