<?php

namespace app\modules\Codnitive\Core\models\System\Source;

class AutoGeneratePatterns extends \app\modules\Codnitive\Core\models\System\Source\OptionsArray
{
    public const ALPHANUMERIC = 1;
    public const ALPHABETIC   = 2;
    public const NUMERICE     = 3;

    public const ALPHANUMERIC_KEYSPACE = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public const ALPHABETIC_KEYSPACE   = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public const NUMERICE_KEYSPACE     = '0123456789';

    protected $_module = \app\modules\Codnitive\Core\Module::MODULE_ID;

    public function optionsArray(): array
    {
        return [
            self::ALPHANUMERIC => __($this->getModule(), 'Alphanumeric'),
            self::ALPHABETIC   => __($this->getModule(), 'Alphabetic'),
            self::NUMERICE     => __($this->getModule(), 'Numeric'),
        ];
    }

    public static function getRandomStringKeyspace(int $patternId): string
    {
        $map = [
            self::ALPHANUMERIC => self::ALPHANUMERIC_KEYSPACE,
            self::ALPHABETIC   => self::ALPHABETIC_KEYSPACE,
            self::NUMERICE     => self::NUMERICE_KEYSPACE,
        ];
        return $map[$patternId];
    }
}
