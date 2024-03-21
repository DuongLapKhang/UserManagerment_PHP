<?php

session_start();
require_once ('config.php');
require_once ('includes/connect.php');
require_once ('includes/databases.php');
require_once ('includes/functions.php');
require_once ('includes/session.php');

// $session_test = setSession('KhangDuong','KhangDuong value');
// var_dump($session_test);

// removeSession('KhangDuong');
// echo getSession('KhangDuong');


// setFlashData('KD', 'Cài đặt thành công');
echo getFlashData('KD');

// Thiết lập đường dẫn an toàn
$module = _MODULE;
$action = _ACTION;

if (!empty ($_GET['module'])) {
    if (is_string($_GET['module'])) {
        $module = trim($_GET['module']);
    }
}

if (!empty ($_GET['action'])) {
    if (is_string($_GET['action'])) {
        $action = trim($_GET['action']);
    }
}

$path = 'modules/' . $module . '/' . $action . '.php';

if (file_exists($path)) {
    require_once ($path);
} else {
    require_once ('modules/error/404.php');
}