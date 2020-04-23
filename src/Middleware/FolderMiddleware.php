<?php


namespace App\Middleware;


use App\Routing\Route;
use App\Service\FolderService;

class FolderMiddleware
{
    private  FolderService $folderService;
    public function __construct(FolderService $folder_service)
    {
        $this->folderService = $folder_service;
    }

    public function run(Route $route)
    {
        $controller = $route->getController();
        $folders = $this->folderService->getFoldersFirstLevel();
        $controller->addSharedData("folders",$folders);
    }
}