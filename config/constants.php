<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database Connection
if(!defined('DB_HOST'))define('DB_HOST', 'localhost');
if(!defined('DB_USER'))define('DB_USER', 'root');
if(!defined('DB_PASS'))define('DB_PASS', 'root');
if(!defined('DB_NAME'))define('DB_NAME', 'deutsch');

// Email for the verification
if(!defined('EMAIL'))define('EMAIL', 'programmingbddprojectrobot@gmail.com');
if(!defined('PASSWORD'))define('PASSWORD', '2019Ecam');

// Path Variables
if(!defined('ROOT_PATH'))define('ROOT_PATH', '/Deutsch/');

function clean_data($data){
    if(DB_USER !== 'root'){
        $data = utf8_encode($data);
    }
    return $data;
}


function echo_clean($data){
    if(DB_USER !== 'root'){
        $data = utf8_encode($data);
    }
    echo $data;
}
