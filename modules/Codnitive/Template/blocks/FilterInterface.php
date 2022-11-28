<?php 

namespace app\modules\Codnitive\Template\blocks;

interface FilterInterface
{
    public function getFilters(): array;

    public function getFilterOptions(string $keyColumn, string $valueColumn, string $translator, array $moreInfo): array;

    public function getFilterRange(string $column, array $moreInfo, int $rangeSteps): array;

    public function getPriceRange(string $column, array $moreInfo, int $rangeSteps): array;
    
}
