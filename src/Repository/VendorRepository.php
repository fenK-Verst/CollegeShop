<?php


namespace App\Repository;


use App\Db\ObjectDataManager;
use App\Entity\Folder;

/**
 * Class FolderRepository
 *
 * @package App\Repository
 * @method Folder find(string $primary_key_value)
 * @method Folder findOrCreate(string $primary_key_value)
 * @method Folder[] findAll()
 */
class FolderRepository extends AbstractRepository
{
    public function __construct(ObjectDataManager $dataManager)
    {
        parent::__construct($dataManager, Folder::class);
    }
}