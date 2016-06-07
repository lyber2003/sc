<?php
define('DS', DIRECTORY_SEPARATOR);
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__FILE__));
}
if (!defined('VENDOR_PATH')) {
    define('VENDOR_PATH', ROOT_PATH.'/vendor');
}
if (!defined('DOCUMENT_ROOT')) {
    define('DOCUMENT_ROOT', ROOT_PATH.'/public');
}
if (!defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', ROOT_PATH.'/app');
}
if (!defined('MODULE_PATH')) {
    define('MODULE_PATH', APPLICATION_PATH.'/modules');
}
if (!defined('CACHE_PATH')) {
    define('CACHE_PATH', dirname(__FILE__).'/app/var/cache');
}