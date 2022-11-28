<?php 

namespace app\modules\Codnitive\Template\blocks;

use app\modules\Codnitive\Core\models\DynamicModel;

interface ToolbarInterface
{
    public function getNameSpace(): string;

    public function getSearchParams(): array;

    public function getDate(): string;

    public function getFormModel($day): DynamicModel;

    public function getDayUrl(string $day): string;

    public function getPrevDayUrl(): string;

    public function getNextDayUrl(): string;

    public function getUrlParams(DynamicModel $searchModel): array;
}
