<?php


namespace App\Repository;


use App\Db\ObjectManager;
use App\Entity\Folder;

/**
 * Class FolderRepository
 *
 * @package App\Repository
 * @method Folder find(string $primary_key_value)
 * @method Folder findOrCreate(string $primary_key_value)
 * @method Folder findBy(array $where, array $order = [], array $limit = []) : array
 * @method Folder[] findAll()
 */
class FolderRepository extends AbstractRepository
{
    public function __construct(ObjectManager $object_manager)
    {
        parent::__construct($object_manager, Folder::class);
    }
}