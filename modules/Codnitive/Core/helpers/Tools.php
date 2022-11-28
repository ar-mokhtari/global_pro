<?php

namespace app\modules\Codnitive\Core\helpers;

// use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

// use yii\helpers\VarDumper;
// use yii\web\ServerErrorHttpException;
// use app\modules\Codnitive\Template\assets\Main;

class Tools /*extends Html*/
{
    public static $sortArrayByArrayOrder;

    public function __construct()
    {
        self::$whitelistIPs = app()->params['whitelistIPs'];
    }

    public static $whitelistIPs = [];

    public static $skipRequestFields = [
        '__stripEscapePost', '__stripEscapeGet', '_csrf'
    ];

    // public static function t()
    // {
    //     Yii::t();
    // }

    // public static function assetsRegister($view)
    // {
    //     Main::register($view);
    // }

    public static function hasModule($moduleName)
    {
        return app()->hasModule($moduleName);
    }

    public static function csrfMetaTags()
    {
        return Html::csrfMetaTags();
    }

    public static function getCsrfInput()
    {
        $token = self::getCsrfToken();
        $name  = self::getCsrfName();
        return '<input type="hidden" name="'.$name.'" value="'.$token.'"/>';
    }

    public static function getCsrfToken()
    {
        return app()->request->csrfToken;
    }

    public static function getCsrfName()
    {
        return app()->request->csrfParam;
    }

    public static function encode($content, $doubleEncode = true)
    {
        return Html::encode($content, $doubleEncode);
    }

    public static function getFlash($status)
    {
        return app()->session->getFlash($status);
    }

    public static function getBaseUrl(bool $forceAbsolute = false)
    {
        $absolute = 'https';
        if(in_array($_SERVER['REMOTE_ADDR'], self::$whitelistIPs) && !$forceAbsolute){
            $absolute = true;
        }
        return Url::base($absolute);
    }

    public static function getPreviousUrl()
    {
        $homeUrl     = app()->homeUrl;
        $previousUrl = app()->request->referrer ?: $homeUrl;
        $currentUrl  = static::getRequestUrl();
        // $currentUrl  = static::getUrl(static::getRequestUrl());
        return $currentUrl != $previousUrl ? $previousUrl : $homeUrl;
    }

    public static function getCurrentUrl(string $lang = '', bool $justPath = false)
    {
        $currentUrl = $justPath
            ? static::getRequestPath()
            : static::getRequestUrl();
        if (!empty($lang)) {
            // var_dump($currentUrl);
            $currentUrl = preg_replace('/^\/\w{2}/', "/$lang", $currentUrl);
        }
        return $currentUrl;
    }

    public static function getUrl($route = '', $params = [], $withSuffix = false, $absolute = 'https', bool $forceAbsolute = false)
    {
        if(in_array($_SERVER['REMOTE_ADDR'], self::$whitelistIPs) && !$forceAbsolute){
            $absolute = false;
        }

        $lang  = self::getLang();
        // $base  = $lang != 'def' ? "@web/$lang/" : '@web/';
        $base = '@web/';
        // var_dump($route);
        if (preg_match('/^\/\w{2}$/', $route)) {
            // var_dump($route);
            $base = '@web/';
        }
        if ('def' != $lang) {
            $base  = preg_match('/^\/\w{2}\//', $route) ? '@web/' : "@web/$lang/";
        }
        $route = [$base . trim($route, '/')];
        $url   = array_merge($route, $params);
        $url   = Url::to($url, $absolute);
        if ('def' != $lang && substr_count($url, "/$lang") > 1) {
            $pattern = '/'.str_replace('/', '\/', $url).'/';
            $url = preg_replace($pattern, "/$lang", $url);
        }
        return $withSuffix ? $url : str_replace('.html', '', $url);
    }

    public static function getRequestUrl()
    {
        return app()->request->url;
    }

    public static function getRequestPath()
    {
        return app()->request->pathInfo;
    }

    public static function isHomePage()
    {
        $url = preg_replace('/\w{2}/', "", self::getRequestPath());
        return empty($url);
    }

    public static function getMediaUrl(string $path = ''): string
    {
        return rtrim(self::getBaseUrl().'/media/'.$path, '/');
    }
    
    public static function getImageUrl(string $imagePath = ''): string
    {
        return self::getMediaUrl("images/$imagePath");
    }

    public static function getUser()
    {
        return \app()->user;
    }

    public static function isGuest()
    {
        return self::getUser()->isGuest;
    }

    public static function isSuperAdmin()
    {
        return !self::isGuest() &&
            \in_array(
                self::getUser()->identity->username,
                \app()->getModule('user')->superadmins
            );
    }

    public static function isAdmin()
    {
        return !self::isGuest() && (self::isSuperAdmin() || self::getUser()->identity->isAdmin);
    }

    public static function isAgent()
    {
        return self::isSuperAdmin() || 
            (!self::isGuest() &&
            \in_array(
                self::getUser()->identity->username,
                \app()->getModule('user')->agents
            )
        );
    }

    public static function isReporter()
    {
        return self::isSuperAdmin() || 
            (!self::isGuest() &&
            \in_array(
                self::getUser()->identity->username,
                \app()->getModule('user')->reporters
            )
        );
    }

    public static function isAdminPanel(): bool
    {
        $request = self::stripEscapeRequest(app()->getRequest());
        if ('admin' === app()->controller->id) {
            return true;
        }
        if (null !== $request->post('admin')) {
            return $request->post('admin');
        }
        if (null !== $request->get('admin')) {
            return $request->get('admin');
        }
        return false;
    }

    public static function showInAdminPanel()
    {
        return self::isAdmin() && self::isAdminPanel();
    }

    public static function getUserNameParts()
    {
        $name = explode(' ', self::getUser()->identity->fullname);
        return [
            'firstname' => $name[0],
            'lastname'  => trim(str_replace($name['0'], '', self::getUser()->identity->fullname))
        ];
    }

    public static function getLang()
    {
        $def = 'fa';
        if (!preg_match('/^\/\w{2}$/', self::getCurrentUrl())) {
            $def = 'def';
        }
        return self::stripEscapeUserInput(app()->getRequest()->get('lang', $def));
    }

    public static function getLanguage()
    {
        return self::getOptionValue(
            'Language', 
            'Langi18n', 
            self::getLang()
        );
    }

    public static function genderOptions()
    {
        return self::getOptionsArray('Core', 'Gender');
        // return \app\modules\Codnitive\Account\models\System\Source\Gender::optionsArray();
    }

    public static function getOptionsArray($module, $source, $translation = true)
    {
        $className = self::getOptionArrayClassName($module, $source);
        return (new $className)->translation($translation)->optionsArray();
    }

    public static function getOptionsKeys($module, $source, $translation = true)
    {
        $options = self::getOptionsArray($module, $source, $translation);
        return array_keys($options);
    }

    public static function getOptionsValues($module, $source, $translation = true)
    {
        $options = self::getOptionsArray($module, $source, $translation);
        return array_values($options);
    }

    public static function getOptionIdByValue($module, $source, $value, $translation = true)
    {
        $className = self::getOptionArrayClassName($module, $source);
        return is_array($value)
            ? (new $className)->translation($translation)->getArrayOptionIdByValue($value)
            : (new $className)->translation($translation)->getOptionIdByValue($value);
    }

    public static function getOptionValue($module, $source, $id, $translation = true)
    {
        $className = self::getOptionArrayClassName($module, $source);
        return (new $className)->translation($translation)->getOptionValue($id);
    }

    public static function getOptionArrayClassName($module, $source)
    {
        return '\app\modules\Codnitive\\'.ucfirst($module).'\models\System\Source\\'.ucfirst($source);
    }

    public static function dateExpired($dateToCheck, $baseDate = 'Today')
    {
        if (!self::isValidDate($baseDate)) {
            $baseDate = self::getWhenDate($baseDate);
        }
        return self::dateDiff($baseDate, $dateToCheck, '%R%a') <= 0;
    }

    /**
     * PARA: Date Should In YYYY-MM-DD Format
     * RESULT FORMAT:
     * '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'  =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
     * '%y Year %m Month %d Day'                                =>  1 Year 3 Month 14 Days
     * '%m Month %d Day'                                        =>  3 Month 14 Day
     * '%d Day %h Hours'                                        =>  14 Day 11 Hours
     * '%d Day'                                                 =>  14 Days
     * '%h Hours %i Minute %s Seconds'                          =>  11 Hours 49 Minute 36 Seconds
     * '%i Minute %s Seconds'                                   =>  49 Minute 36 Seconds
     * '%h Hours                                                =>  11 Hours
     * '%a Days                                                 =>  468 Days
     */
    public static function dateDiff($firstDate, $secondDate, $differenceFormat = '%a')
    {
        $firstDateObj  = date_create($firstDate);
        $secondDateObj = date_create($secondDate);
        $interval      = date_diff($firstDateObj, $secondDateObj);
        return $interval->format($differenceFormat);
    }

    /**
     * Date format:
     * '2006-04-14T11:30:00' or 'Y-m-d H:i:s'
     * 
     * $duration format help:
     * https://en.wikipedia.org/wiki/ISO_8601#Durations
     * 
     * @link https://stackoverflow.com/questions/3108591/calculate-number-of-hours-between-2-dates-in-php
     */
    public static function timeDiff($oldDate, $newDate, $duration)
    {
        $oldDate = (new \DateTime($oldDate))->setTimezone(new \DateTimeZone('UTC'));
        $newDate = (new \DateTime($newDate))->setTimezone(new \DateTimeZone('UTC'));

        //determine what interval should be used - can change to weeks, months, etc
        $interval = new \DateInterval($duration);

        //create periods every hour between the two dates
        $periods = new \DatePeriod($oldDate, $interval, $newDate);

        //count the number of objects within the periods
        return iterator_count($periods);
    }

    /**
     * Date format:
     * '2006-04-14T11:30:00' or 'Y-m-d H:i:s'
     * 
     * $duration format help:
     * https://en.wikipedia.org/wiki/ISO_8601#Durations
     */
    public static function hoursDiff($oldDate, $newDate)
    {
        return self::timeDiff($oldDate, $newDate, 'PT1H'/*$duration*/);
    }

    /**
     * Date format:
     * '2006-04-14T11:30:00' or 'Y-m-d H:i:s'
     * 
     * $duration format help:
     * https://en.wikipedia.org/wiki/ISO_8601#Durations
     */
    public static function minutesDiff($oldDate, $newDate)
    {
        return self::timeDiff($oldDate, $newDate, 'PT1M'/*$duration*/);
    }

    /*public static function timeExpired($timeToCheck, $baseTime = '')
    {
        // if (empty($baseTime)) {
        //     $date = new \DateTime();
        //     $baseTime = $date->format('H:i');
        // }

        $dateTime = new \DateTime($timeToCheck);
        return time() >= strtotime($timeToCheck);
        // var_dump((int) self::dateDiff($timeToCheck, $baseTime, '%R%h'));
        // // exit;
        // return ((int) self::dateDiff($timeToCheck, $baseTime, '%R%h') <= 0);
    }*/

    /**
     * Check if the value is a valid date
     *
     * @param mixed $date
     *
     * @return boolean
     */
    public static function isValidDate($date) 
    {
        if (!$date) {
            return false;
        }

        try {
            (new \DateTime($date))->setTimezone(new \DateTimeZone('UTC'));
            return true;
        } 
        catch (\Exception $e) {
            return false;
        }
    }

    // public static function getWeeKEndDate()
    // {
    //     $date = new \DateTime('this week +6 days');
    //     // $date->modify('this week +6 days');
    //     return $date->format('Y-m-d');
    // }

    // public static function getMonthEndDate()
    // {
    //     $date = new \DateTime('this month');
    //     return $date->format('Y-m-t');
    // }

    // public static function getNextMonthDates()
    // {
    //     $date = new \DateTime('next month');
    //     $month = [
    //         $date->format('Y-m-01'),
    //         $date->format('Y-m-t'),
    //     ];
    //     return $month;
    // }

    // public static function getYearEndDate()
    // {
    //     $date = new \DateTime('last day of December');
    //     return $date->format('Y-m-t');
    // }

    public static function getWhenDates($when = null)
    {
        $date = (new \DateTime())->setTimezone(new \DateTimeZone(app()->timeZone));
        $startDate = $date->format('Y-m-d');
        switch (strtolower($when)) {
            case 'today':
                $endDate = $startDate;
                break;
            
            case 'tomorrow':
                $endDate = $date->modify('tomorrow')->format('Y-m-d');
                break;

            case 'this week':
                $endDate = $date->modify('this week +6 days')->format('Y-m-d');
                break;

            case 'this month':
                $thisMonth = $date->modify('this month');
                $startDate = $thisMonth->format('Y-m-01');
                $endDate   = $thisMonth->format('Y-m-t');
                break;

            case 'next month':
                $nextMonth = $date->modify('next month');
                $startDate = $nextMonth->format('Y-m-01');
                $endDate   = $nextMonth->format('Y-m-t');
                break;

            case 'expired':
                $endDate = $startDate;
                $startDate = $date->modify('today -3650 days')->format('Y-m-01');
                break;

            default:
                // $endDate = $date->modify('last day of December')->format('Y-m-t');
                $endDate = $date->modify('today +3650 days')->format('Y-m-t');
        }

        return [
            'start_date' => $startDate,
            'end_date'   => $endDate
        ];
    }

    public static function getWhenDate($when = null, string $from = 'today', string $format = 'Y-m-d')
    {
        $date = self::getWhenDateObject($when, $from);
        return empty($format) ? $date : $date->format($format);
    }

    public static function getWhenDateTimestamp($when = null, string $from = 'today')
    {
        return self::getWhenDateObject($when, $from)->getTimestamp();
    }

    public static function getWhenDateObject($when = null, string $from = 'today')
    {
        $date = (new \DateTime($from))->setTimezone(new \DateTimeZone(app()->timeZone));
        return $date->modify($when);
    }

    public static function getNow(string $format = 'Y-m-d H:i:s')
    {
        return (new \DateTime())->setTimezone(new \DateTimeZone(app()->timeZone))->format($format);
    }

    public static function getTimestamp($format = 'c')
    {
        $date = new \DateTime();
        return $date->setTimezone(new \DateTimeZone(app()->timeZone))->format($format);
    }

    public static function getFormattedDate($date, $format = 'j F Y')
    {
        return date($format, strtotime($date));
    }

    public static function getISO8601DateTime(string $date, bool $removeTimezoneDiff = false)
    {
        $format = self::getFormattedDate($date, 'c');
        return !$removeTimezoneDiff ? $format : explode('+', $format)[0];
    }

    public static function getFormattedTime($time, $format = 'g:i A')
    {
        return date($format, strtotime($time));
    }

    public static function formatNumber($number, $decimals = 2, $decimalsPoint = '.', $decimalsSeparator = ',')
    {
        return number_format($number, $decimals, $decimalsPoint, $decimalsSeparator);
    }

    public static function formatMoney(
        $number, 
        $format = '$<span class="d-inline-block ltr">{{price}}</span>',
        $options = ['decimals' => 2, 'decimals_point' => '.', 'decimals_separator' => ',']
    ) {
        $price = self::formatNumber(
            $number, 
            $options['decimals'], 
            $options['decimals_point'], 
            $options['decimals_separator']
        );
        return str_replace('{{price}}', $price, $format);
        // $price = self::formatNumber($number);
        // setlocale(LC_MONETARY, 'en_US');
        // return money_format('%i', $price);
    }

    public static function formatRial(float $price, bool $withSymbol = true): string
    {
        $format = $withSymbol ? '$<span class="d-inline-block ltr">{{price}}</span>' : '<span class="d-inline-block ltr">{{price}}</span>';
        return self::formatMoney($price, __('language', $format), [
            'decimals' => 0,
            'decimals_point' => '.',
            'decimals_separator' => ','
        ]);
    }

    /**
     * @link https://stackoverflow.com/questions/1699958/formatting-a-number-with-leading-zeros-in-php
     * 
     * sprintf('%08d', 1234567); // faster on php 7
     * OR
     * str_pad($value, 8, '0', STR_PAD_LEFT);
     */
    public static function addLeadingZero(int $number, string $length): string
    {
        return sprintf("%0{$length}d", $number);
    }

    public static function isJson($string): bool
    {
        if (!is_string($string)) {
            return false;
        }
        return (strpos($string, '{') !== false) || (strpos($string, '[') !== false);
    }

    /**
     * $strip can be string or array
     * 
     * @param $strip string|array
     * @return string|array
     */
    public static function stripOutInvisibles($value)
    {
        return preg_replace('/\p{C}+/u', '', $value);
    }

    public static function formatUrl(string $str): string
    {
        $removeCharacters = [',', ';'];
        $invalidCharacters = ['&', '?', '=', '/', '\\'];
        $str = str_replace($removeCharacters, '', $str);
        $str = str_replace($invalidCharacters, '-', $str);
        return preg_replace(['/\++/', '/\-+/'], '-', urlencode($str));
    }

    public static function getImagePath($model, $userId = 0, $index = 0)
    {
        if (!$userId) {
            $userId = $model->user_id;
        }
        if (is_array($model)) {
            $imageName = $index === false
                ? $model['name']
                : $model[$index]['name'];
        }
        else {
            $imageName = $index === false
                ? $model->images['name']
                : $model->images[$index]['name'];
        }
        return "/$userId/$imageName";
    }

    public static function registerError($sessionKey, $errorKey, $errorMessage)
    {
        $session = app()->session;
        $errors = $session->get($sessionKey);
        $errors[$errorKey][] = $errorMessage;
        $session->set($sessionKey, $errors);
    }

    public static function getPerPageSize()
    {
        return tools()->stripEscapeRequest(app()->getRequest())->get(
            'per-page', 
            \app\modules\Codnitive\Core\models\Grid\GridAbstract::PAGE_SIZE
        );
    }

    public static function findInArrayAndSortByArray(array $haystack, array $orderArray): array
    {
        $foundArray = array_filter($haystack, function($value) use ($orderArray) {
            return in_array($value, $orderArray);
        });

        self::$sortArrayByArrayOrder  = $orderArray;
        usort($foundArray, [__CLASS__, 'sortArrayByArray']);
        return $foundArray;
    }

    public static function sortArrayByArray($a, $b) 
    {
        foreach (self::$sortArrayByArrayOrder as $key => $value) { 
            if ($a == $value) return false; 
            if ($b == $value) return true;
        } 
    }
    
    public static function sortArrayKeysByArray(array $haystack, array $orderArray): array
    {
        return array_merge(array_flip($orderArray), $haystack);
    }

    public static function convertFormArrayToModelArray($dataArray)
    {
        $data = [];
        foreach ($dataArray as $field => $values) {
            if (is_array($values)) {
                // $values = array_values($values);
                foreach ($values as $key => $value) {
                    $data[$key][$field] = $value;
                }
            }
        }
        unset($data[9999999999]);
        return $data;
    }

    // @link https://stackoverflow.com/a/18186761/1227224
    public static function arrayInsertBefore($input, $index, $element) 
    {
        if (!array_key_exists($index, $input)) {
            throw new \Exception("Index not found");
        }
        $tmpArray = [];
        $originalIndex = 0;
        foreach ($input as $key => $value) {
            if ($key === $index) {
                $tmpArray[] = $element;
                break;
            }
            $tmpArray[$key] = $value;
            $originalIndex++;
        }
        array_splice($input, 0, $originalIndex, $tmpArray);
        return $input;
    }

    // @link https://stackoverflow.com/a/18186761/1227224
    public static function arrayInsertAfter($input, $index, $element) 
    {
        if (!array_key_exists($index, $input)) {
            throw new \Exception("Index not found");
        }
        $tmpArray = [];
        $originalIndex = 0;
        foreach ($input as $key => $value) {
            $tmpArray[$key] = $value;
            $originalIndex++;
            if ($key === $index) {
                $tmpArray[] = $element;
                break;
            }
        }
        array_splice($input, 0, $originalIndex, $tmpArray);
        return $input;
    }

    /** 
     * $array => original array
     * $keysMap => array containing old keys as keys and new keys as values
     */
    public static function recursiveChangeArrayKey(array $array, array $keysMap): array
    {
        $newArray = [];
        foreach ($array as $k => $v) {
            $key = array_key_exists($k, $keysMap) ? $keysMap[$k] : $k;
            $newArray[$key] = is_array($v) ? self::recursiveChangeArrayKey($v, $keysMap) : $v;
        }
        return $newArray;
    }

    public static function recursiveObjectToArray($obj, int $offset = 0, int $level = 100) 
    {
        //only process if it's an object or array being passed to the function
        if ((is_object($obj) || is_array($obj)) && $offset < $level) {
            $ret = (array) $obj;
            $offset++;
            foreach($ret as &$item) {
                //recursively process EACH element regardless of type
                $item = self::recursiveObjectToArray($item, $offset, $level);
            }
            return $ret;
        }
        //otherwise (i.e. for scalar values) return without modification
        else {
            return $obj;
        }
    }

    public static function recursiveArrayCleanClassNameFromKeys($array, int $offset = 0, int $level = 100)
    {
        if (is_array($array) && $offset < $level) {
            $offset++;
            $newArray = [];
            foreach($array as $key => $item) {
                $key = preg_match('/^\x00(?:.*?)\x00(.+)/', $key, $matches) ? $matches[1] : $key;
                $newArray[$key] = self::recursiveArrayCleanClassNameFromKeys($item, $offset, $level);
            }
            return $newArray;
        }
        //otherwise (i.e. for scalar values) return without modification
        else {
            return $array;
        }
    }

    public static function recursiveArrayResetKeys(array $array): array
    {
        return array_map('array_values', $array);
    }

    public static function arraySetFieldAsKey(array $array, $arrayKeyField): array
    {
        return array_combine(array_column($array, $arrayKeyField), $array);
    }

    public static function createArrayFromArrayColumns(array $array, $keyColumn, $valueColumn): array
    {
        return array_combine(
            array_column($array, $keyColumn), 
            array_column($array, $valueColumn)
        );
    }

    public static function filterArrayKeysByArray(array $array, array $allowedKeys): array
    {
        return \array_filter(
            $array,
            function ($key) use ($allowedKeys) {
                return in_array($key, $allowedKeys);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    public static function recursiveStripEscapeUserInputs($inputs, int $offset = 0, int $level = 100)
    {
        if (is_array($inputs) && $offset < $level) {
            $offset++;
            foreach($inputs as &$input) {
                $input = self::recursiveStripEscapeUserInputs($input, $offset, $level);
            }
            return $inputs;
        }
        //otherwise (i.e. for scalar values) return without modification
        else {
            return self::stripEscapeUserInput($inputs);
        }
    }

    // Guides:
    /**
     * @link https://www.dreamhost.com/blog/php-security-user-validation-sanitization/
     * strip_tags(trim())
     * 
     */
    /**
     * @link https://www.yiiframework.com/doc/api/2.0/yii-helpers-htmlpurifier
     * \yii\helpers\HtmlPurifier::process($html);
     * 
     */
    /**
     * @link https://www.sitepoint.com/community/t/addslashes-vs-mysql-real-escape-string-the-final-debate/2376/12
     * @link http://shiflett.org/blog/2006/addslashes-versus-mysql-real-escape-string
     * addcslashes(mysqli_real_escape_string($not_escaped), "\0..\37!@\177..\377");
     * 
     * addslashes(mysqli_real_escape_string(
     * mysqli_real_escape_string
     */
    /**
     * use in active recored save method collection and load one and other query places
     * $quoteValue = \Yii::$app->db->quoteValue($value);
     * 
     */
    /**
     * also use param binding:
     * @link https://www.yiiframework.com/doc/guide/2.0/en/db-query-builder#where
     * @link https://stackoverflow.com/questions/27267624/mysqli-real-escape-string-within-yii-2-using-dao-or-something-else
     * 
     */
    /**
     * prevent from Cross-site Injection (for print user data output, for example user commands which we need to accept user html code) 
     * echo htmlentities ( trim ( $comment ) , ENT_NOQUOTES );
     * 
     */
    public static function stripEscapeUserInput($input)
    {
        // NOTE: you can use stripslashes to remove addes slashes later
        return \yii\helpers\HtmlPurifier::process(addslashes(strip_tags(trim($input))));
    }

    public static function stripEscapeRequest(\yii\web\Request $request): \yii\web\Request
    {
        $post = $request->post();
        $get  = $request->get();
        $key  = crc32(self::stripEscapeUserInput(self::getCsrfToken() . app()->params['secret_key']));

        if (!empty($post) && (!isset($post['__stripEscapePost']) || $post['__stripEscapePost'] !== $key)) {
            $requestPost = self::recursiveStripEscapeUserInputs($post);
            $requestPost['__stripEscapePost'] = $key;
            $request->setBodyParams($requestPost);
        }
        if (!empty($get) && (!isset($get['__stripEscapeGet']) || $get['__stripEscapeGet'] !== $key)) {
            $requestGet  = self::recursiveStripEscapeUserInputs($get);
            $requestGet['__stripEscapeGet'] = $key;
            $request->setQueryParams($requestGet);
        }
        return $request;
    }

    public static function skipRequestFields(string $title): bool
    {
        return in_array($title, self::$skipRequestFields);
    }

    /**
     * @link https://stackoverflow.com/a/31107425/2373138
     * 
     * Generate a random string, using a cryptographically secure 
     * pseudorandom number generator (random_int)
     *
     * This function uses type hints now (PHP 7+ only), but it was originally
     * written for PHP 5 as well.
     * 
     * For PHP 7, random_int is a PHP core function
     * For PHP 5.x, depends on https://github.com/paragonie/random_compat
     * 
     * @param int $length      How many characters do we want?
     * @param string $keyspace A string of all possible characters
     *                         to select from
     * @return string
     */
    function generateRandomString(
        int $length = 64,
        string $keyspace = \app\modules\Codnitive\Core\models\System\Source\AutoGeneratePatterns::ALPHANUMERIC_KEYSPACE
    ): string 
    {
        if ($length < 1) {
            throw new \RangeException(__('core', 'Length must be a positive integer'));
        }
        $pieces = [];
        $keyspace = str_shuffle($keyspace);
        $max      = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces[] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    // @link https://stackoverflow.com/a/11480852/1227224
    public static function getUrlStrParameters(string $url): array
    {
        $parts = parse_url($url);
        $query = [];
        if (isset($parts['query'])) {
            parse_str($parts['query'], $query);
        }
        return $query;
    }

    public static function ToLatina($string)
    {
        $persian_num = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $latin_num = range(0, 9);
        $string = str_replace($persian_num, $latin_num, $string);
        return $string;
    }


    protected array $digit1 = array(
        0 => 'صفر',
        1 => 'یک',
        2 => 'دو',
        3 => 'سه',
        4 => 'چهار',
        5 => 'پنج',
        6 => 'شش',
        7 => 'هفت',
        8 => 'هشت',
        9 => 'نه',
    );
    protected $digit1_5 = array(
        1 => 'یازده',
        2 => 'دوازده',
        3 => 'سیزده',
        4 => 'چهارده',
        5 => 'پانزده',
        6 => 'شانزده',
        7 => 'هفده',
        8 => 'هجده',
        9 => 'نوزده',
    );
    protected $digit2 = array(
        1 => 'ده',
        2 => 'بیست',
        3 => 'سی',
        4 => 'چهل',
        5 => 'پنجاه',
        6 => 'شصت',
        7 => 'هفتاد',
        8 => 'هشتاد',
        9 => 'نود'
    );
    protected $digit3 = array(
        1 => 'صد',
        2 => 'دویست',
        3 => 'سیصد',
        4 => 'چهارصد',
        5 => 'پانصد',
        6 => 'ششصد',
        7 => 'هفتصد',
        8 => 'هشتصد',
        9 => 'نهصد',
    );
    protected $steps = array(
        1 => 'هزار',
        2 => 'میلیون',
        3 => 'بیلیون',
        4 => 'تریلیون',
        5 => 'کادریلیون',
        6 => 'کوینتریلیون',
        7 => 'سکستریلیون',
        8 => 'سپتریلیون',
        9 => 'اکتریلیون',
        10 => 'نونیلیون',
        11 => 'دسیلیون',
    );
    protected $t = array(
        'and' => 'و',
    );

    function number_format($number, $decimal_precision = 0, $decimals_separator = '.', $thousands_separator = ',') {
        $number = explode('.', str_replace(' ', '', $number));
        $number[0] = str_split(strrev($number[0]), 3);
        $total_segments = count($number[0]);
        for ($i = 0; $i < $total_segments; $i++) {
            $number[0][$i] = strrev($number[0][$i]);
        }
        $number[0] = implode($thousands_separator, array_reverse($number[0]));
        if (!empty($number[1])) {
            $number[1] = $this->Round($number[1], $decimal_precision);
        }
        return implode($decimals_separator, $number);
    }

    protected function groupToWords($group) {
        $d3 = floor($group / 100);
        $d2 = floor(($group - $d3 * 100) / 10);
        $d1 = $group - $d3 * 100 - $d2 * 10;

        $group_array = array();

        if ($d3 != 0) {
            $group_array[] = $this->digit3[$d3];
        }

        if ($d2 == 1 && $d1 != 0) { // 11-19
            $group_array[] = $this->digit1_5[$d1];
        } else if ($d2 != 0 && $d1 == 0) { // 10-20-...-90
            $group_array[] = $this->digit2[$d2];
        } else if ($d2 == 0 && $d1 == 0) { // 00
        } else if ($d2 == 0 && $d1 != 0) { // 1-9
            $group_array[] = $this->digit1[$d1];
        } else { // Others
            $group_array[] = $this->digit2[$d2];
            $group_array[] = $this->digit1[$d1];
        }

        if (!count($group_array)) {
            return FALSE;
        }

        return $group_array;
    }

    public function numberToWords($number) {
        $formated = $this->number_format($number, 0, '.', ',');
        $groups = explode(',', $formated);

        $steps = count($groups);

        $parts = array();
        foreach ($groups as $step => $group) {
            $group_words = self::groupToWords($group);
            if ($group_words) {
                $part = implode(' ' . $this->t['and'] . ' ', $group_words);
                if (isset($this->steps[$steps - $step - 1])) {
                    $part .= ' ' . $this->steps[$steps - $step - 1];
                }
                $parts[] = $part;
            }
        }
        return implode(' ' . $this->t['and'] . ' ', $parts);
    }


}
