<?php 

namespace app\modules\Codnitive\Template\blocks;

use yii\helpers\ArrayHelper;

trait FilterTrait
{
    protected $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }
    
    public function getArrayColumn(string $column): array
    {
        $result = array_unique(array_column($this->data, $column));
        return is_array($result) ? $result : [];
    }

    public function getFilterOptions(string $keyColumn, string $valueColumn, string $translator = 'template', array $moreInfo = [], string $sortType = ''): array
    {
        $options = [];
        foreach ($this->data as $option) {
            $options[$option[$keyColumn]] = __($translator, $option[$valueColumn]);
        }
        $options = array_unique($options);
        if (!empty($sortType)) {
            $sortType($options);
        }
        if (count($options) > 1) {
            return ArrayHelper::merge([
                'list' => $options,
                'collapsible' => true,
            ], $moreInfo);
        }
        return [];
    }

    public function getFilterRange(string $column, array $moreInfo = [], int $rangeSteps = 1): array
    {
        $moreInfo = ArrayHelper::merge([
            'title' => __('template', ucwords(str_replace('_', ' ', $column))), 
            'collapsible' => false,
            'format_hour' => false
        ], $moreInfo);
        $ranges = $this->getArrayColumn($column);
        if (empty($ranges)) {
            return ['min' => 0, 'max' => 0, 'step' => 0];
        }

        foreach ($ranges as $key => $number) {
            $ranges[$key] = intval($number);
        }
        return ArrayHelper::merge([
            'min' => min($ranges),
            'max' => max($ranges),
            'step' => $rangeSteps,
            'disabled' => true
        ], $moreInfo);
    }

    public function getPriceRange(string $column = 'final_price', array $moreInfo = [], int $rangeSteps = 100000): array
    {
        $moreInfo = ArrayHelper::merge(['title' => __('template', 'Price (Rial)'), 'collapsible' => false], $moreInfo);
        $prices = $this->getArrayColumn($column);
        if (empty($prices)) {
            return ['min' => 0, 'max' => 0, 'step' => 0];
        }

        $minPrice = min($prices);
        $maxPrice = max($prices);
        $minPrice = round(floor($minPrice - $rangeSteps), -strlen((string) $minPrice) + strlen($rangeSteps));
        $maxPrice = round(ceil($maxPrice + $rangeSteps), -strlen((string) $maxPrice) + strlen($rangeSteps));

        return ArrayHelper::merge([
            'min' => $minPrice,
            'max' => $maxPrice,
            'step' => $rangeSteps,
            'disabled' => false,
            'format_hour' => false
        ], $moreInfo);
    }
}
