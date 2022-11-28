<?php 

namespace app\modules\Codnitive\Core\models;

use yii\helpers\ArrayHelper;
use app\modules\Codnitive\Core\models\System\Source\PopularCities;

abstract class RepositoryAbstract
{
    protected $modulesList = [];

    protected $repositories = [];

    protected $_repository = '';

    protected $_repositoryObj;

    public function __construct(string $repository = '')
    {
        if (!empty($this->repositories)) {
            uasort($this->repositories, ['app\modules\Codnitive\Core\models\RepositoryAbstract', 'sortRepositories']);
        }
        if (!empty($repository)) {
            $this->setRepository($repository)->loadRepositoryObject();
        }
    }

    public function setRepository(string $repository): self
    {
        // if ($this->_useProviderId) {
        //     $repository = $this->getRepositoryNameById((int) $repository);
        // }
        $this->_repository = strtolower($repository);
        return $this;
    }

    public function getRepository(): string
    {
        return $this->_repository;
    }

    public function validateRepository(string $repository): bool
    {
        if ($this->_useProviderId) {
            $repository = $this->getRepositoryNameById((int) $repository);
        }
        return (bool) in_array($repository, array_keys($this->repositories));
    }

    public function getRepositoryName($provider): string
    {
        if ($this->_useProviderId && intval($provider)) {
            $provider = $this->getRepositoryNameById(intval($provider));
        }
        return $provider;
    }

    public function getRepositoryNameById(int $providerId): string
    {
        return tools()->getOptionValue('Core', 'Vendors', $providerId);
    }

    public function loadRepositoryObject()
    {
        $dataRepository = $this->repositories[$this->getRepositoryName($this->_repository)]['data_repository'];
        $this->_repositoryObj = new $dataRepository(
            ...$this->repositories[$this->getRepositoryName($this->_repository)]['repository_arguments'] ?? []
        );
        return $this;
    }

    public function getRepositoryObject()
    {
        if (empty($this->_repositoryObj)) {
            $this->loadRepositoryObject();
        }
        return $this->_repositoryObj;
    }

    public function getFinalPrice(array $data, string $passengerType = ''): float
    {
        return $this->getRepositoryObject()->getFinalPrice($data, $passengerType);
    }

    public function getGrandTotal(array $data): float
    {
        return $this->getRepositoryObject()->getGrandTotal($data);
    }

    protected function _makeUniqueNames(array $cities): array
    {
        $uniqueCities   = [];
        foreach ($cities as $cityId => $cityName) {
            $oldCityId = array_search($cityName, $uniqueCities);
            if ($oldCityId) {
                unset($uniqueCities[$oldCityId]);
                $cityId = $oldCityId . ";$cityId";
            }
            $uniqueCities[$cityId] = $cityName;
        }
        return $this->_sortPopularCities($uniqueCities);
    }
    
    protected function _sortPopularCities(array $cities): array
    {
        $firstCities    = [];
        $popularCities  = (new PopularCities)->optionsArray();
        foreach ($cities as $cityId => $cityName) {
            if (in_array($cityName, $popularCities)) {
                $firstCities[$cityId] = $cityName;
                unset($cities[$cityId]);
            }
        }

        // @link https://stackoverflow.com/questions/348410/sort-an-array-by-keys-based-on-another-array
        // @link http://php.net/manual/en/function.array-filter.php
        $firstCities = array_filter(array_flip(array_replace(array_flip($popularCities), array_flip($firstCities))), function($k) {
            return is_string($k);
        }, ARRAY_FILTER_USE_KEY);
        return ArrayHelper::merge($firstCities, $cities);
    }

    protected function _getSearchCityIds(string $cities): array
    {
        $citiesArray = [];
        foreach (explode(';', $cities) as $city) {
            list($provider, $cityId) = explode(':', $city);
            $citiesArray[$provider][] = $cityId;
        }
        foreach ($citiesArray as $provider => &$cities) {
            $citiesArray[$provider] = array_flip(array_flip($cities));
        }
        return $citiesArray;
    }

    public static function sortRepositories($a, $b)
    {
        return strcmp($a['order'], $b['order']);
        // $a = strtolower($a['order']);
        // $b = strtolower($b['order']);
        // if ($a == $b) {
        //     return 0;
        // }
        // return ($a > $b) ? +1 : -1;
    }
}
