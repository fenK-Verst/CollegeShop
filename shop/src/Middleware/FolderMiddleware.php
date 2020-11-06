<?php


namespace App\Middleware;


use App\Routing\Route;
use App\Service\FolderService;

class FolderMiddleware implements MiddlewareInterface
{
    private  FolderService $folderService;

    public function __construct(FolderService $folder_service)
    {
        $this->folderService = $folder_service;
    }

    public function run(Route $route)
    {
        $folders = $this->folderService->getFoldersFirstLevel();
        $route->addSharedData("folders",$folders);
    }
}