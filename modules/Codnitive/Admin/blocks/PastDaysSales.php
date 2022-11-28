<?php 

namespace app\modules\Codnitive\Admin\blocks;

use app\modules\Codnitive\Core\blocks\Template;
use app\modules\Codnitive\Reports\models\PastDaysOrders;
use app\modules\Codnitive\Calendar\models\Persian;

class PastDaysSales extends Template
{
    protected $pastDaysOrders;
    protected $_sales = [];
    protected $_days = \app\modules\Codnitive\Reports\models\PastDaysOrders::MAX_DAYS;

    public function __construct(int $days = \app\modules\Codnitive\Reports\models\PastDaysOrders::MAX_DAYS)
    {
        $this->pastDaysOrders = new PastDaysOrders;
        $this->_days = $days;
    }

    public function getDays(): int
    {
        return $this->_days;
    }

    public function loadSales(int $orderStatus = 0): self
    {
        $this->_sales = $this->pastDaysOrders
            ->setDays($this->_days)
            ->setOrderStatus($orderStatus)
            ->getSales();
        return $this;
    }

    public function getChartLables(): string
    {
        $labels = '';
        $calendar = new Persian;
        foreach (array_column($this->_sales, 'period') as $period) {
            $period  = $calendar->getDate($period, 'y-m-d');
            $labels .= "'$period', ";
        }
        return rtrim($labels, ', ');
    }

    public function getChartValues(): string
    {
        return implode(', ', array_column($this->_sales, 'total'));
    }
}
