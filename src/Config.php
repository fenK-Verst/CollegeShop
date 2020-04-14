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
}