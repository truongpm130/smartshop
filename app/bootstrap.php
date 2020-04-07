<?php

require_once 'config/config.php';

require_once 'helpers/url_helper.php';

require_once 'helpers/session_helper.php';

require_once 'helpers/string_helper.php';

require_once 'helpers/time_helper.php';

// Auto load libraries
spl_autoload_register(function($className) {
    require_once 'libraries/' . $className . '.php';
});