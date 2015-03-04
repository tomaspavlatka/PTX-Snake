<?php

spl_autoload_register('__autoload');
function __autoload($class_name) {
    $namespace = null;
    if(strstr($class_name, '\\')) {
        list($namespace, $class_name) = explode('\\', $class_name);
    }

    require_once './classes/' . $class_name . '.php';
}

function debug($data) {
    echo '<pre>';
        print_r($data);
    echo '</pre>';
}