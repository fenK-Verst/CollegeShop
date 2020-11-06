<?php


namespace App\Repository;


use App\Db\Interfaces\ObjectManagerInterface;
use App\Entity\Stonk;
use App\Entity\User;

/**
 * Class StonkRepository
 *
 * @package App\Repository
 * @method Stonk find(string $primary_key_value)
 * @method Stonk findOrCreate(string $primary_key_value)
 * @method array findBy(array $where, array $order = [], array $limit = [])
 * @method array findOneBy(array $where, array $order = [])
 * @method Stonk[] findAll()
 */
class StonkRepository extends AbstractRepository
{
    public function __construct(ObjectManagerInterface $object_manager, string $entity_class = Stonk::class)
    {
        parent::__construct($object_manager, Stonk::class);
    }

    public function getWithDate(User $user, \DateTime $dateStart, \DateTime $dateEnd)
    {

        $adm = $this->getObjectManager()->getObjectDataManager()->getArrayDataManager();
        $start = $dateStart->format("Y-m-d H:i:s");
        $end = $dateEnd->format("Y-m-d H:i:s");
        $user_id = $user->getId();
        $query = "SELECT id FROM stonk WHERE user_id = $user_id AND  created_at BETWEEN '$start' AND '$end'";
        $result = $adm->query($query);
        $a = [];
        if (is_bool($result)) return [];
        while ($stonk = $result->fetch_assoc()) {
            $a[] = $this->find($stonk["id"]);
        }
        return $a;
    }
}