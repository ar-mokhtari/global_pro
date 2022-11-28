<?php

namespace app\modules\Codnitive\Core\models\System\Source;

abstract class OptionsArray
{
    protected $_module = '';

    protected $_translation = true;

    // public function __construct()
    // {
    //     if (!empty($this->getModule())) {
    //         app()->getModule($this->getModule());
    //     }
    // }

    abstract public function optionsArray(): array;

    public function setModule(string $module): self
    {
        $this->_module = $module;
        return $this;
    }

    public function translation(bool $translation): self
    {
        $this->_translation = $translation;
        return $this;
    }

    public function getModule(): string
    {
        return $this->_translation ? $this->_module : '';
    }

    public function getOptionIdByValue($value): string
    {
        return array_search($value, $this->optionsArray());
    }

    public function getArrayOptionIdByValue($value): array
    {
        return array_intersect($this->optionsArray(), $value);
    }

    public function getOptionValue($id): string
    {
        return isset($this->optionsArray()[$id]) ? $this->optionsArray()[$id] : '';
    }

    public function getOptionsKeys(): array
    {
        return array_keys($this->optionsArray());
    }

    public function getOptionsValues(): array
    {
        return array_values($this->optionsArray());
    }
}
