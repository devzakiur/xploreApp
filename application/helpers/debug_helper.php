<?php

header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('debug_r')) {

    function debug_r($value) {
        echo "<pre>";
            print_r($value);
        echo "</pre>";
        die();
    }
}
if (!function_exists('debug_v')) {

    function debug_v($value) {
        echo "<pre>";
            var_dump($value);
        echo "</pre>";
        die();
    }
}