<?php 

function getObject(string $className, array $params = [])
{
    $container = new \yii\di\Container;
    return $container->get($className, $params);
}
