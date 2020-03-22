<?php

require_once 'config/config.php';

require_once 'helpers/url_helper.php';

// Auto load libraries
spl_autoload_register(function($className) {
    require_once 'libraries/' . $className . '.php';
});