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

//session_save_path(PROJECT_DIR."var/sessions");
session_set_cookie_params(0);
if (!session_id()){
    session_start();
}
require_once(PROJECT_DIR . "/vendor/autoload.php");
//phpinfo();
$container = new Container([
    ConnectionInterface::class => Connection::class,
    ArrayDataManagerInterface::class => ArrayDataManager::class,
    ObjectDataManagerInterface::class => ObjectDataManager::class,
    ObjectManagerInterface::class => ObjectManager::class,
]);
$container->singletone(Container::class, function () use ($container) {
    return $container;
});
$container->singletone(Config::class);
$container->singletone(ObjectManager::class);
$container->singletone(ArrayDataManager::class);
$container->singletone(ObjectDataManager::class);
$container->singletone(Response::class);
$container->singletone(Request::class);
$container->singletone(Twig::class);
$container->singletone(CustomRouter::class);
$container->singletone(Router::class);
$container->singletone(Connection::class, function () {
    $host = getenv("DB_HOST");
    $db_name = getenv("DB_NAME");
    $password = getenv("DB_PASSWORD");
    $user = getenv("DB_USER");
    $port = (int)getenv("DB_PORT");
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

