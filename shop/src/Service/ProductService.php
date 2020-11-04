<?php


namespace App\Service;


use App\Repository\FolderRepository;
use App\Routing\Route;

class ProductService
{
    private FolderRepository $folderRepository;

    public function __construct(FolderRepository $repository)
    {
        $this->folderRepository = $repository;
    }


}