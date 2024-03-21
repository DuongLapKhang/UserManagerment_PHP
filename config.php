<?php
const _MODULE = 'home';
const _ACTION = 'dasboard';
const _CODE = true;

// Thiết lập đường dẫn HOST
define('_WEB_HOST', 'http://'. $_SERVER['HTTP_HOST'].'/UserManagerment/');
define('_WEB_HOST_TEMPLATES', _WEB_HOST.'/templates');

// Thiết lập đường dẫn file
define('_WEB_PATH', __DIR__);
define('_WEB_PATH_TEMPLATES', _WEB_PATH.'/templates');