<?php 

namespace app\modules\Codnitive\Admin\blocks;

use app\modules\Codnitive\Core\blocks\Template;
use app\modules\Codnitive\Reports\models\TodayOrders as TodayReports;

class TodayOrders extends Template
{
    protected $todayReports;

    public function __construct()
    {
        $this->todayReports = new TodayReports;
    }

    public function getTotalSales(): float
    {
        return floatval($this->todayReports->getTodayOrders()->sum('grand_total'));
    }

    public function getTotalSoldTickets(): int
    {
        return intval($this->todayReports->getTodayOrderItems()->count());
    }

    public function getTotalSalesQty(): int
    {
        return intval($this->todayReports->getTodayOrderItems()->distinct()->count());
    }

    public function getChartLables(): string
    {
        $labels = '';
        foreach (app()->params['modules']['products'] as $product) {
            $lable = __('admin', $product);
            $labels .= "'$lable', ";
        }
        return rtrim($labels, ', ');
    }

    public function getChartValues(): string
    {
        $qtys = [];
        foreach (app()->params['modules']['products'] as $product) {
            $qtys[] = $this->todayReports->getTodayOrderItems()
                ->andWhere(['ticket_type' => $product])
                ->count();
        }
        return implode(', ', $qtys);
    }
}
