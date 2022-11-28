<?php

function __($category, $message, $params = [], $language = null)
{
    if (empty($category)) {
        return $message;
    } 
    return \Yii::t($category, $message, $params, $language);
}
