<?php


namespace App;


use App\Controller\DefaultController;
use App\Controller\FolderController;
use App\Controller\ProductController;

class Config
{
    public function getControllers()
    {
        return [
            FolderController::class,
            ProductController::class,
            DefaultController::class,

        ];
    }

    public function getTwigConfig()
    {
        return [
            "cache" => '/var/cache',
            "templates" => '/templates',
            "auto_reload"=>true,
        ];
    }

}