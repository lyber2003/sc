#!/usr/bin/env php
<?php
/**
 * SosCredit Initialization Tool
 */

if (!extension_loaded('openssl')) {
    die('The OpenSSL PHP extension is required by Yii2.');
}

$root = str_replace('\\', '/', __DIR__);
echo "Current directory: " . $root . "\n";


$exec = shell_exec ( 'ls -al'  );
echo $exec;
$exec = shell_exec ( 'chmod -R 777 .'  );
echo $exec;
$exec = shell_exec ( 'ls -al'  );
echo $exec;
$exec = shell_exec ( 'composer update'  );
echo $exec;
$exec = shell_exec ( 'php  app/migration/phinx migrate' );
echo $exec;




