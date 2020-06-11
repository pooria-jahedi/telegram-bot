<?php

/**
 * Read config files and return config
 * @param $src
 * @return array
 */
function config($src)
{
    $arrayOfIndexes = explode(".", $src);
    /** @var array $array */
    /** @var array $arrayOfIndexes */
    $config = include "./config/{$arrayOfIndexes[0]}.php";
    array_shift($arrayOfIndexes);
    foreach ($arrayOfIndexes as $index) {
        $config = isset($config[$index]) ? $config[$index] : null;
    }
    return $config;
}

