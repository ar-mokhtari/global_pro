<?php 

namespace app\modules\Codnitive\Core\models;

trait RepositoryTrait
{
    protected $_repo;
    protected $_headings;
    
    protected function addProviderToData(string $provider, int $uniqueId = -1): void
    {
        array_walk(
            $this->_repo,
            function (&$row) use ($provider, $uniqueId) {
                $row['provider'] = $provider;
                if (-1 !== $uniqueId) {
                    $id = $row[$uniqueId];
                    $row[$uniqueId] = "$provider:$id";
                }
            }
        );
    }

    protected function addHeadings(bool $addProvider = false): void
    {
        if ($addProvider) {
            $this->_headings[4] = 'provider';
        }
        $headings = $this->_headings;
        array_walk(
            $this->_repo,
            function (&$row) use ($headings) {
                $row = array_combine($headings, $row);
            }
        );
    }
}
