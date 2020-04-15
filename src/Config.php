<?php


namespace App;


use App\Controller\FolderController;

class Config
{
    public function getControllers()
    {
        return [
            FolderController::class
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