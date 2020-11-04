<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
use App\Entity\Folder;

/**
 * Class FolderRepository
 *
 * @package App\Repository
 * @method Folder find(string $primary_key_value)
 * @method Folder findOrCreate(string $primary_key_value)
 * @method Folder findBy(array $where, array $order = [], array $limit = []) : array
 * @method Folder findOneBy(array $where, array $order = []) : array
 * @method Folder[] findAll()
 */
class FolderRepository extends AbstractRepository
{
    public function __construct(ObjectManagerInterface $object_manager, string $entity_class = Folder::class)
    {
        parent::__construct($object_manager, Folder::class);
    }

    public function getSubFolders(Folder $folder)
    {
        $folder_id = $folder->getId();
        $adm = $this->getObjectManager()->getObjectDataManager()->getArrayDataManager();
        $lvl = (int)$folder->getLvl()+1;
        $left = $folder->getLeft();
        $right = $folder->getRight();
        $query = "SELECT id FROM folder WHERE _left > $left AND _right < $right AND _lvl = $lvl";
        $result = $adm->query($query);

        $a = [];
        while($value = $result->fetch_assoc()){
            $a[] = $this->find($value["id"]);
        }
        return $a;
    }

    public function getParents(Folder $folder, bool $widthFolder)
    {
        $adm = $this->getObjectManager()->getObjectDataManager()->getArrayDataManager();
        $lvl = (int)$folder->getLvl();
        $left = (int)$folder->getLeft();
        $right = (int)$folder->getRight();
        if ($widthFolder){
            $query = "SELECT id FROM folder WHERE _left <= $left AND _right >= $right ORDER BY _left";
        }else{
            $query = "SELECT id FROM folder WHERE _left < $left AND _right > $right ORDER BY _left";
        }


        $result = $adm->query($query);

        $a = [];
        while($value = $result->fetch_assoc()){
            $a[] = $this->find($value["id"]);
        }
        return $a;
    }
}