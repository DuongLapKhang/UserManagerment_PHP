<!-- Các hàm dùng chung -->
<?php
if (!defined('_CODE')) {
    die ('Access denied...');
}

function insertLayout($nameLayout = 'name', $data = [])
{
    $pathLayout = _WEB_PATH_TEMPLATES . '/layout/' . $nameLayout . '.php';
    if (file_exists($pathLayout)) {
        require_once ($pathLayout);
    }
}