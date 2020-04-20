<?php

use App\Config;
use App\Db\Connection;
use App\Di\Container;
use App\Http\Request;
use App\Http\Response;
use App\Kernel;
use App\Twig;


define("PROJECT_DIR", __DIR__ . "/../");
require_once(PROJECT_DIR . "/vendor/autoload.php");

$container = new Container([
    "App\Db\Interfaces\ConnectionInterface" => Connection::class
]);
$container->singletone(Container::class, function () use ($container) {
    return $container;
});
$container->singletone(Config::class);
$container->singletone(Response::class);
$container->singletone(Request::class);
$container->singletone(Connection::class, function () {
    $host = getenv("DB_HOST");
    $db_name = getenv("DB_NAME");
    $password = getenv("DB_PASSWORD");
    $user = getenv("DB_USER");
    $port = getenv("DB_PORT");
    return new Connection($host, $user, $password, $db_name, $port);
});
$container->singletone(Twig::class);

$kernel = $container->get(Kernel::class);

