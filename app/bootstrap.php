<?php

require_once 'config/config.php';

// Auto load libraries
spl_autoload_register(function($className) {
    require_once 'libraries/' . $className . '.php';
});