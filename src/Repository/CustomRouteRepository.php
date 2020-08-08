<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
use App\Db\ObjectManager;
use App\Entity\CustomRoute;

/**
 * Class CustomRouteRepository
 *
 * @package App\Repository
 * @method CustomRoute find(string $primary_key_value)
 * @method CustomRoute findOrCreate(string $primary_key_value)
 * @method CustomRoute findBy(array $where, array $order = [], array $limit = []) : array
 * @method CustomRoute[] findAll()
 */
class CustomRouteRepository extends AbstractRepository
{
    public function __construct(ObjectManagerInterface $object_manager, string $entity_class = CustomRoute::class)
    {
        parent::__construct($object_manager, CustomRoute::class);
    }
    public function getParent(CustomRoute $custom_route)
    {
        $adm = $this->getObjectManager()->getObjectDataManager()->getArrayDataManager();
        $left = $custom_route->getLeft();
        $right = $custom_route->getRight();
        $lvl = (int)$custom_route->getLvl()-1;
        $query = "SELECT id FROM route WHERE _left < $left AND _right > $right AND _lvl = $lvl  ORDER BY _left DESC LIMIT 1";

        $result = $adm->query($query);

        $a = null;
        while($value = $result->fetch_assoc()){
            $a = $this->find($value["id"]);
        }
        return $a;
    }

    public function getChilds(CustomRoute $route)
    {
        $adm = $this->getObjectManager()->getObjectDataManager()->getArrayDataManager();
        $left = $route->getLeft();
        $right = $route->getRight();
        $query = "SELECT id FROM route WHERE _left > $left AND _right < $right ORDER BY _left";

        $result = $adm->query($query);

        $a = [];
        while($value = $result->fetch_assoc()){
            $a[] = $this->find($value["id"]);
        }
        return $a;
    }
}