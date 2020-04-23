<?php


namespace App\Service;


use App\Repository\FolderRepository;
use App\Routing\Route;

class FolderService
{
    private FolderRepository $folderRepository;
    public function __construct(FolderRepository $repository)
    {
       $this->folderRepository = $repository;
    }

    public function getFoldersFirstLevel()
    {
        return $this->folderRepository->findBy([
           "_lvl"=>0
        ]);
    }
}