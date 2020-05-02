<?php


use App\Config;
use App\Db\Connection;
use App\Di\Container;
use App\Http\Request;
use App\Http\Response;
use App\Kernel;
use App\Twig;


define("PROJECT_DIR", __DIR__ . "/../");

session_save_path(PROJECT_DIR."var/sessions");
if (!session_id()){
    session_start();
}
require_once(PROJECT_DIR . "/vendor/autoload.php");
//phpinfo();
$container = new Container([
    \App\Db\Interfaces\ConnectionInterface::class => Connection::class,
    \App\Db\Interfaces\ArrayDataManagerInterface::class => \App\Db\ArrayDataManager::class,
    \App\Db\Interfaces\ObjectDataManagerInterface::class => \App\Db\ObjectDataManager::class,
    \App\Db\Interfaces\ObjectManagerInterface::class => \App\Db\ObjectManager::class,
]);
$container->singletone(Container::class, function () use ($container) {
    return $container;
});
$container->singletone(Config::class);
$container->singletone(\App\Db\ObjectManager::class);
$container->singletone(\App\Db\ArrayDataManager::class);
$container->singletone(\App\Db\ObjectDataManager::class);
$container->singletone(Response::class);
$container->singletone(Request::class);
$container->singletone(Twig::class);
$container->singletone(Connection::class, function () {
    $host = getenv("DB_HOST");
    $db_name = getenv("DB_NAME");
    $password = getenv("DB_PASSWORD");
    $user = getenv("DB_USER");
    $port = getenv("DB_PORT");
    return new Connection($host, $user, $password, $db_name, $port);
});
$dev =  getenv("env");
if (strtolower($dev) == "prod" ){
    set_error_handler(function ($errno, $errstr, $errfile, $errline) use ($container) {
        if ($errno >= 500) {
            print_r($errfile . "\n");
            print_r($errline);
            $twig = $container->get(Twig::class);
            echo $twig->render("HttpErrors/error.html.twig", [
                "code" => 500,
                "name" => $errstr
            ]);
            die();
        }
    });
}

$kernel = $container->get(Kernel::class);

