<?php

function strlimit($string, $limit) {

    $length = strlen($string);
    if ($length > $limit) {
        $string = substr($string, 0, $limit-3) . ' ... ';
    }
    return $string;
}

function test_input($data) {
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}