<?php

use App\Controller\Admin\AdminController;
use App\Controller\Admin\FlagAdminController;
use App\Controller\Admin\FolderAdminController;
use App\Controller\Admin\ImageAdminController;
use App\Controller\Admin\MenuAdminController;
use App\Controller\Admin\ProductAdminController;
use App\Controller\Admin\ProductParamAdminController;
use App\Controller\Admin\VendorAdminController;
use App\Controller\Api\AuthApiController;
use App\Controller\Api\CartApiController;
use App\Controller\Api\ImageApiController;
use App\Controller\Api\MenuApiController;
use App\Controller\Api\RouteApiController;
use App\Controller\Api\StonkApiController;
use App\Controller\Api\TestApiController;
use App\Controller\CartController;
use App\Controller\DefaultController;
use App\Controller\FolderController;
use App\Controller\OrderController;
use App\Controller\ProductController;
use App\Controller\SearchController;
use App\Controller\UserController;

return [
    TestApiController::class,
    AdminController::class,
    FolderAdminController::class,
    ProductAdminController::class,
    VendorAdminController::class,
    FlagAdminController::class,
    ImageAdminController::class,
    MenuAdminController::class,
    ProductParamAdminController::class,
    ImageApiController::class,
    MenuApiController::class,
    CartApiController::class,
    RouteApiController::class,
    StonkApiController::class,
    AuthApiController::class,
    DefaultController::class,
    UserController::class,
    SearchController::class,
    ProductController::class,
    FolderController::class,
    CartController::class,
    OrderController::class

];