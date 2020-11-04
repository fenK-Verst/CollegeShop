<?php

use App\Db\ArrayDataManager;
use App\Db\Connection;
use App\Db\Interfaces\ArrayDataManagerInterface;
use App\Db\Interfaces\ConnectionInterface;
use App\Db\Interfaces\ObjectDataManagerInterface;
use App\Db\Interfaces\ObjectManagerInterface;
use App\Db\ObjectDataManager;
use App\Db\ObjectManager;

return [
    ConnectionInterface::class => Connection::class,
    ArrayDataManagerInterface::class => ArrayDataManager::class,
    ObjectDataManagerInterface::class => ObjectDataManager::class,
    ObjectManagerInterface::class => ObjectManager::class,
];