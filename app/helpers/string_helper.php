<?php

function strlimit($string, $limit) {

    $length = strlen($string);
    if ($length > $limit) {
        $string = substr($string, 0, $limit-3) . ' ... ';
    }
    return $string;
}