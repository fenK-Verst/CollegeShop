<?php


use App\Config;
use App\Db\ArrayDataManager;
use App\Db\Connection;
use App\Db\Interfaces\ArrayDataManagerInterface;
use App\Db\Interfaces\ConnectionInterface;
use App\Db\Interfaces\ObjectDataManagerInterface;
use App\Db\Interfaces\ObjectManagerInterface;
use App\Db\ObjectDataManager;
use App\Db\ObjectManager;
use App\Di\Container;
use App\Http\Request;
use App\Http\Response;
use App\Kernel;
use App\Routing\CustomRouter;
use App\Routing\Router;
use App\Twig;

define("PROJECT_DIR", __DIR__ . "/../");
require_once(PROJECT_DIR . "/vendor/autoload.php");
session_set_cookie_params(0);
if (!session_id()){
    session_start();
}

$config = new Config();
$interfaceMapping = $config->get('interface.mapping');
$singletons = $config->get('singletons');

$container = new Container($interfaceMapping);

$container->singleton(Container::class, function () use ($container) {
    return $container;
});
foreach ($singletons as $class=>$callable){
    $container->singleton($class, $callable);
}
$kernel = $container->get(Kernel::class);

