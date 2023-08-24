<?php

require_once __DIR__ . '/../vendor/autoload.php'; // composer autoload

function value(array $array, $key, $defaultValue = null) {
    return array_key_exists($key, $array) ? $array[$key] : $defaultValue;
}