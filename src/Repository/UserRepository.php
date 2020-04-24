<?php


namespace App\Repository;


use App\Db\ObjectManager;
use App\Entity\User;

/**
 * Class UserRepository
 *
 * @package App\Repository
 * @method User find(string $primary_key_value)
 * @method User findOrCreate(string $primary_key_value)
 * @method User findBy(array $where, array $order = [], array $limit = []) : array
 * @method User[] findAll()
 */
class UserRepository extends AbstractRepository
{
    public function __construct(ObjectManager $object_manager)
    {
        parent::__construct($object_manager, User::class);
    }
    public function getNonUnique(User $user)
    {
        $email = $user->getEmail();
        $phone = $user->getPhone();
        $arm = $this->getObjectManager()->getObjectDataManager()->getArrayDataManager();
        $email = strtolower($arm->escape($email));
        $phone = $arm->escape($phone);
        $query = "SELECT COUNT(id) as count FROM user WHERE phone LIKE \"%$phone%\" OR LOWER(email) LIKE \"$email\"";
        $count = $arm->fetchAllArray($query);
        return $count[0]["count"];

    }
}