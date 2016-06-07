#!/usr/bin/env php
<?php
require_once __DIR__ . '/../const.php';
chdir(__DIR__);
require_once VENDOR_PATH.'/autoload.php';

require ROOT_PATH.'/bootstrap/environment.php';

array_shift($argv);
$count = count($argv);
if ($count < 2) {
	if ($count == 0) {
		throw new \Vein\Core\Exception('CLI router arguments not have task and action');
	} 
	if ($count == 1) {
		throw new \Vein\Core\Exception('CLI router arguments not have action');
	}
}
$params = ['module' => 'generator'];
$params['task'] = array_shift($argv);
$params['action'] = array_shift($argv);
if ($argv) {
	$params = array_merge($params, $argv);
}

try {
	require_once ROOT_PATH . '/app/Cli.php';
	$application = new Cli();
	$application->run();
	$application->handle($params);
} catch (Exception $e) {
	\Vein\Core\Error::exception($e);
	echo $e->getMessage()."\n";
}
