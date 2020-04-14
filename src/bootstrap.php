<?php


use App\Di\Container;
use App\Kernel;


define("PROJECT_DIR", __DIR__ . "/../");
require_once(PROJECT_DIR . "/vendor/autoload.php");

$container = new Container();

$kernel = $container->get(Kernel::class);

