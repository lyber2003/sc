<?php
ini_set('display_errors', 1);
ini_set('xdebug.max_nesting_level', 10000);

require_once __DIR__ . '/../const.php';
chdir(__DIR__);
require_once VENDOR_PATH.'/autoload.php';

require ROOT_PATH.'/bootstrap/environment.php';
$debug = new \Phalcon\Debug();
$debug->listen();
try {
    require_once ROOT_PATH . '/app/Application.php';
    $application = new Application();
    $application->run();
    echo $application->getOutput();
} catch (Exception $e) {
    \Vein\Core\Error::exception($e);
    throw $e;
}