<?php 

namespace app\modules\Codnitive\Template\blocks;

use app\modules\Codnitive\Calendar\models\Persian;
use app\modules\Codnitive\Core\models\DynamicModel;

trait ToolbarTrait
{
    protected $_searchFormClass = '';
    protected $_urlPath = '';

    public function getSearchParams(): array
    {
        return \app\modules\Codnitive\Checkout\helpers\Data::getCart($this->getNameSpace());
    }

    public function getDate(): string
    {
        return str_replace('-', '/', $this->getSearchParams()['departing_persian']);
        // return (new Persian)->getDate($this->getSearchParams()['departing']);
    }

    public function getFormModel($day): DynamicModel
    {
        $date = new \DateTime($this->getSearchParams()['departing']);
        $departing = $date->modify($day)->format('Y-m-d');
        $departingPersian = (new Persian)->getDate($departing);
        
        $searchForm = getObject($this->_searchFormClass);
        $searchForm->attributes = $this->getSearchParams();
        $searchForm->departing = $departing;
        $searchForm->departing_persian = $departingPersian;
        return $searchForm;
    }

    public function getDayUrl(string $day): string
    {
        // $searchParams = $this->getSearchParams();
        $searchModel = $this->getFormModel($day);
        $urlParams = $this->getUrlParams($searchModel);
        $urlParams['day'] = $day == '+1 day' ? 'next' : 'prev';
        // $roundTrip = [];
        // if (isset($searchParams['path'])) {
        //     $urlParams['path'] = $searchParams['path'];
        // }
        // if (isset($searchParams['trip'])) {
        //     $roundTrip['trip'] = $searchParams['trip'];
        // }
        // if (!empty($roundTrip)) {
        //     $urlParams['flight'] = $roundTrip;
        // }
        return tools()->getUrl($this->_urlPath, $urlParams);
    }

    public function getPrevDayUrl(): string
    {
        return $this->getDayUrl('-1 day');
    }

    public function getNextDayUrl(): string
    {
        return $this->getDayUrl('+1 day');
    }
}
