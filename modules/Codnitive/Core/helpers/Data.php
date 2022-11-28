<?php

namespace app\modules\Codnitive\Core\helpers;

use Yii;
// use yii\helpers\Json;

class Data
{

    public static function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        }
        else {
            return null;
        }
    }

    // protected function _log ($message, $action/* , $dir = '' */)
    // {
    //     /* global $timestamp;
    //     // global $syncherId;
    //     // global $syncherName;
    //     global $action; */
    //     /* $timestamp = date('Ymd'); */
    //     // $fileName = \Yii::getAlias('@app') . '/modules/Codnitive/var/log/'. $action . $timestamp . /*'-syncher'. $syncherId . '-'. $syncherName .*/ '.log';
    //     // $dir = \Yii::getAlias('@app') . '/var/log';
    //     $path = \Yii::getAlias('@app') . '/runtime/logs';
    //     /* if (!empty($dir)) {
    //         $path = '/' . $dir;
    //     }
    //     if (!file_exists($path) || !is_dir($path)) {
    //         mkdir($path, '0755', true);
    //     } */
    //     $fileName = $path . '/' . $action . '.log';
    //     // $result = file_put_contents($fileName, date('m-d H:i:s') . "\t" . $message, FILE_APPEND);
    //     @file_put_contents($fileName, date('m-d H:i:s') . "\t" . $message, FILE_APPEND);
    // }
    protected static function _log ($message, $action)
    {
        $path = \Yii::getAlias('@app') . '/runtime/logs';
        $fileName = $path . '/' . $action . '.log';
        @file_put_contents($fileName, date('m-d H:i:s') . "\t" . $message, FILE_APPEND);
    }

    public static function log ($error, $errorCode)
    {
        $date = date('Ymd');
        $timestamp = time() . ' ' . $date;
        $errorNumber = "Error #: {$errorCode}-{$timestamp}\n";
        $file = "$errorCode-$date";
        $session = app()->session;
        $ActiveRecordErrorsKey = \app\modules\Codnitive\Core\models\ActiveRecord::ERROR_REGISTRY_KEY;

        self::_log($errorNumber, $file);
        if ($session->has($ActiveRecordErrorsKey)) {
            self::_log(print_r($session->get($ActiveRecordErrorsKey), true), $file);
            $session->remove($ActiveRecordErrorsKey);
        }
        self::_log($error, $file);
        self::_log(sprintf("\n%s\n", str_repeat('_', 1920)), $file);

        return YII_DEBUG ? "<pre style='direction: ltr; text-align: left'>$error</pre>" : $errorNumber;
    }

    public static function setFlash($type, $message)
    {
        app()->getSession()->setFlash($type, $message);
    }

}
