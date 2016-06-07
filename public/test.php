<?php
$config = array(
    "host" => "localhost",
    "dbname" => "dev_soscredit",
    "port" => 3306,
    "username" => "dev_soscredit",
    "password" => "dev_soscredit"
);

use Phalcon\Di\FactoryDefault;

$di = new FactoryDefault();
$di->set('db', function() use ($config) {
    return new \Phalcon\Db\Adapter\Pdo\Mysql([
        "host"     => $config['host'],
        "username" => $config['username'],
        "password" => $config['password'],
        "dbname"   => $config['dbname']
    ]);
});

include '../apps/modules/Order/Model/OrderTest.php';

$m = \Order\Model\OrderTest::findFirst();

die('2132');

