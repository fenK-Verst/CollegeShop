<?php

use App\Config;
use App\Db\ArrayDataManager;
use App\Db\Connection;
use App\Db\ObjectDataManager;
use App\Db\ObjectManager;
use App\Http\Request;
use App\Http\Response;
use App\Routing\CustomRouter;
use App\Routing\Router;
use App\Twig;

return [
    Config::class => null,
    ObjectManager::class => null,
    ArrayDataManager::class => null,
    ObjectDataManager::class => null,
    Response::class => null,
    Request::class => null,
    Twig::class => null,
    CustomRouter::class => null,
    Router::class => null,
    Connection::class => function () {
        $host = getenv("DB_HOST");
        $db_name = getenv("DB_NAME");
        $password = getenv("DB_PASSWORD");
        $user = getenv("DB_USER");
        $port = (int)getenv("DB_PORT");
        return new Connection($host, $user, $password, $db_name, $port);
    }
];