<?php

namespace app\modules\Codnitive\Account\helpers;

class Password extends \dektrium\user\helpers\Password
{
    public static function generate($length, $strength = '')
    {
        $sets = self::getPasswordSets($strength);
        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }

        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++) {
            $password .= $all[array_rand($all)];
        }

        $password = str_shuffle($password);

        return $password;
    }

    public static function getPasswordSets($strength = '')
    {
        switch ($strength) {
            // upper and lower letters mix
            case 'alphanumeric_mix':
                $sets = [
                    'abcdefghjkmnpqrstuvwxyz',
                    'ABCDEFGHJKMNPQRSTUVWXYZ',
                    '23456789',
                ];
                break;

            // only lower case letters
            case 'alphanumeric_lower':
                $sets = [
                    'abcdefghjkmnpqrstuvwxyz',
                    '23456789',
                ];
                break;

            // only upper case letters
            case 'alphanumeric_upper':
                $sets = [
                    'ABCDEFGHJKMNPQRSTUVWXYZ',
                    '23456789',
                ];
                break;
                
            // upper and lower letters mix
            case 'alphabetic_mix':
                $sets = [
                    'abcdefghjkmnpqrstuvwxyz',
                    'ABCDEFGHJKMNPQRSTUVWXYZ',
                ];
                break;
                
            // only upper case letters
            case 'alphabetic_upper':
                $sets = [
                    'ABCDEFGHJKMNPQRSTUVWXYZ',
                ];
                break;
                
            // only lower case letters
            case 'alphabetic_lower':
                $sets = [
                    'abcdefghjkmnpqrstuvwxyz',
                ];
                break;
            
            // only numbers
            case 'numeric':
                $sets = [
                    '23456789',
                ];
                break;
                
            default:
                $sets = [
                    'abcdefghjkmnpqrstuvwxyz',
                    'ABCDEFGHJKMNPQRSTUVWXYZ',
                    '23456789',
                ];
        }
        return $sets;
    }
}
