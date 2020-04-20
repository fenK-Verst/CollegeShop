<?php


use App\Di\Container;
use App\Kernel;


define("PROJECT_DIR", __DIR__ . "/../");
require_once(PROJECT_DIR . "/vendor/autoload.php");

$container = new Container();
$container->singletone(\App\Di\Container::class, function () use ($container){
    return $container;
});
$container->singletone(\App\Config::class);
$container->singletone(\App\Twig::class);

$kernel = $container->get(Kernel::class);

