<?php

// DB params
define('DB_HOST','localhost');
define('DB_USER', 'root');
define('DB_PASS', '1231');
define('DB_NAME','smartshop');

define('CHARSET', 'utf8mb4');

// App root
define('APPROOT', dirname(dirname(__FILE__)));

// URL root
define('URLROOT', 'http://localhost/smartshop');

// Site name
define('SITENAME','SmartShop');

// Default Avatar
define('AVATAR', URLROOT . '/images/users/avatar.png');

define('AVATAR_USER_FOLDER', $_SERVER['DOCUMENT_ROOT'].'/smartshop/public/images/users/');

// Photo upload max size
define('MAX_SIZE', 102400);

// Library for product photos
define('PRODUCT_FOLDER', $_SERVER['DOCUMENT_ROOT'].'/smartshop/public/images/products/');

// Library for homepage photos
define('HOMEPAGE_FOLDER', $_SERVER['DOCUMENT_ROOT'].'/smartshop/public/images/homepage/' );

// Products show in one page
define('LIMIT_PRODUCTS', 10);