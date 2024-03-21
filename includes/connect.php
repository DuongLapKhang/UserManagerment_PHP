<?php
if (!defined('_CODE')) {
    die('Access denied...');
}

const _HOST = 'localhost';
const _DB = 'userManagerment';
const _USER = 'root';
const _PASS ='';

try {
    if (class_exists('PDO')) {
        $dsn = 'mysql:dbname='._DB.';host='._HOST;

        $option = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        $connect = new PDO($dsn, _USER, _PASS, $option);
    }
} catch (Exception $exception) {
    echo $exception -> getMessage()."<br>";
    die();
}