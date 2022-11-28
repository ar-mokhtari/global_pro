<?php

namespace app\modules\Codnitive\Core\helpers;

// use Yii;

class Rules
{
    // public const BOOLEAN_PATTERN             = '/^[0-1]$/';
    public const BOOLEAN_PATTERN             = '/^[0,1]$/';
    public const INTERNATIONAL_PHONE_PATTERN = '/^(\+\d{1,3}[- ]?)?\d{8,11}$/';
    public const PHONE_PATTERN               = '/^[0]{1}\d{10}$/';
    public const CELLPHONE_PATTERN           = '/^[0][9]\d{9}$/';
    public const USER_DATE_FORMAT            = 'yyyy/M/d';
    public const DATE_FORMAT                 = 'yyyy-M-d';
    public const TIME_FORMAT                 = 'HH:mm:ss';
    public const IRANIAN_NATIONAL_ID         = '/^\d{10}$/';
    public const IRANIAN_NATIONAL_ID_JS      = '^[0-9]{10}$';
    public const IRANIAN_NATIONAL_ID_NO_ZERO = '/^[0-9]{8,10}$/'; // accept without leading zero
    public const IRANIAN_PASSPORT_NO         = '/^[A-Z0-9<]{7,9}$/';
    public const INTERNATIONAL_PASSPORT_NO   = '/^[A-Z0-9<]{7,9}[0-9]{1}[A-Z]{3}[0-9]{7}[A-Z]{1}[0-9]{7}[A-Z0-9<]{14}[0-9]{2}$/';
    public const INTER_PASSPORT_NO_OPTIONAL  = '/^[A-Z0-9<]{7,9}([0-9]{1}[A-Z]{3}[0-9]{7}[A-Z]{1}[0-9]{7}[A-Z0-9<]{14}[0-9]{2})?$/';
    public const IATA_AIRLINE_PATTERN        = '/^[A-Z0-9]{2,3}$/';
    public const IATA_AIRPORT_PATTERN        = '/^[A-Z]{3}$/';
    public const ENGLISH_NAME                = "/^[a-z ,.'-]+$/i";
    public const ENGLISH_ENTERNATIONAL_NAME  = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/u";
    public const ENGLISH_NUMBER              = "/^[0-9]+$/";
    // public const PERSIAN_NAME                = "/^[\u0600-\u06FF ]+$/";
    // public const PERSIAN_NAME                = "/\p{Arabic}/u";
    public const PERSIAN_NAME                = "/^[\x{0600}-\x{06FF} ]*$/u";
    public const PERSIAN_NUMBER              = "/^[\x{06F0}-\x{06F9}]+$/u";

    public static function trim(array $inputs)
    {
        return [$inputs, 'filter', 'filter' => 'trim', 'skipOnArray' => true];
    }

    public static function unique(array $inputs)
    {
        return [$inputs, 'unique', 'targetAttribute' => $inputs];
    }

    public static function array($input, array $rule)
    {
        return [$input, 'each', 'rule' => $rule];
    }

    public static function json($input)
    {   
        return [$input, function ($attribute, $params, $validator) use ($input) {
            if (!tools()->isJson(self::$attribute)) {
                self::addError($attribute, "$input is not valid JSON");
            }
        }];
    }

    public static function pattern($input, $pattern)
    {
        return [$input, 'match', 'pattern' => $pattern];
    }

    public static function boolean($input)
    {
        return self::pattern($input, self::BOOLEAN_PATTERN);
    }

    public static function phone($input, $international = true)
    {
        $patternt = $international ? self::INTERNATIONAL_PHONE_PATTERN : self::PHONE_PATTERN;
        return self::pattern($input, $patternt);
        // return [$input, 'match', 'pattern' => '/^(\+\d{1,3}[- ]?)?\d{8,11}$/'];
    }

    public static function cellphone($input)
    {
        return self::pattern($input, self::CELLPHONE_PATTERN);
    }

    public static function gender($input = 'gender')
    {
        return self::boolean($input);
        // return self::pattern('gender', '/^[0-1]$/');
        // ['gender', 'match', 'pattern' => '/^[0-1]$/']
    }

    public static function file($input, $extensions, $max = 8)
    {
        return [[$input], 'file', 'extensions' => $extensions, 'maxFiles' => $max, 'skipOnEmpty' => true];
    }

    public static function image($input, $max = 8)
    {
        $extensions = \app\modules\Codnitive\Core\models\FileManager::VALID_IMAGE_EXSTENSIONS;
        return self::file($input, $extensions, $max);
    }

    public static function media($input, $max = 8)
    {
        $extensions = \app\modules\Codnitive\Core\models\FileManager::VALID_MEDIA_EXSTENSIONS;
        return self::file($input, $extensions, $max);
    }

    public static function url($input)
    {
        return [$input, 'url', 'defaultScheme' => 'http'];
    }

    public static function email($input)
    {
        return [$input, 'email'];
    }

    public static function input($input, $type, $length = null, $min = null, $max = null)
    {
        $rule = [$input, $type];
        if (!empty($length)) {
            $rule['length'] = $length;
        }
        if (!empty($min)) {
            $rule['min'] = $min;
        }
        if (!empty($max)) {
            $rule['max'] = $max;
        }
        return $rule;
    }

    public static function string($input, $length = null, $min = null, $max = null)
    {
        return self::input($input, 'string', $length, $min, $max);
    }

    public static function integer($input, $min = null, $max = null)
    {
        return self::input($input, 'integer', null, $min, $max);
    }

    public static function number($input, $min = null, $max = null)
    {
        return self::input($input, 'number', null, $min, $max);
    }

    public static function userDate($input)
    {
        return [$input, 'date', 'format' => self::USER_DATE_FORMAT/*, 'timestampAttribute' => $input*/];
    }

    public static function date($input)
    {
        return [$input, 'date', 'format' => self::DATE_FORMAT/*, 'timestampAttribute' => $input*/];
    }

    public static function time($input)
    {
        return [$input, 'time', 'format' => self::TIME_FORMAT/*, 'timestampAttribute' => $input*/];
    }

    public static function dateCompare(/*$rules, */$fromDate, $toDate)
    {
        return [$toDate, 'compare', 'compareAttribute' => $fromDate, 'operator' => '>=', 'enableClientValidation' => true];
        // $rules[] = [$fromDate, 'date', 'timestampAttribute' => $fromDate];
        // $rules[] = [$toDate, 'date', 'timestampAttribute' => $toDate];
        // $rules[] = [$toDate, 'compare', 'compareAttribute' => $fromDate, 'operator' => '>', 'enableClientValidation' => true];
        // return $rules;
    }

    public static function todayCompare($fromDate)
    {
        // $d = strtotime("10:30pm April 15 2018");
        $yesterday = strtotime("yesterday");
        return [$fromDate, 'compare', 'compareValue' => date('Y-m-d', $yesterday), 'operator' => '>', 'enableClientValidation' => true];
    }

    public static function country()
    {
        return self::string('country', 2);
    }

    public static function division()
    {
        return self::string('division', [2, 200]);
    }

    public static function city()
    {
        return self::string('city', [2, 200]);
    }

    public static function address()
    {
        return self::string('address', [5, 512]);
    }
}
