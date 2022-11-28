<?php 

namespace app\modules\Codnitive\Admin\blocks;

use app\modules\Codnitive\Core\blocks\Template;
use app\modules\Codnitive\Admin\models\GetBalanceInterface;

class Apis extends Template
{
    protected $_apisBalance = [];

    public function __construct()
    {
        $this->_apisBalance = $this->getApisBalance();
    }

    /**
     * @return app\modules\Codnitive\Admin\models\GetBalanceInterface
     */
    public function getApisBalance(): array
    {
        $balances = [];
        foreach (app()->params['api_connector'] as $connector) {
            $obj = new $connector['class'];
            if ($obj instanceof GetBalanceInterface) {
                $balances[$connector['order']] = $obj;
            }
        }
        ksort($balances);
        return $balances;
    }

    public function getChartLables(): string
    {
        $labels = '';
        foreach ($this->_apisBalance as $provider) {
            $label   = $provider->getName();
            $labels .= "'$label', ";
        }
        return rtrim($labels, ', ');
    }

    public function getChartValues(): string
    {
        $values = [];
        foreach ($this->_apisBalance as $provider) {
            $values[] = $provider->getBalance();
        }
        return implode(', ', $values);
    }
}
