<?php

use App\Middleware\CartMiddleware;
use App\Middleware\FolderMiddleware;
use App\Middleware\SharedMiddleware;
use App\Middleware\SiteParamsMiddleware;
use App\Middleware\UserMiddleware;

return[
    FolderMiddleware::class,
    UserMiddleware::class,
    SharedMiddleware::class,
    CartMiddleware::class,
    SiteParamsMiddleware::class,
];