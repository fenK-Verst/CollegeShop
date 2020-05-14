<?php


namespace App\Repository;


use App\Db\ObjectManager;
use App\Entity\Product;

/**
 * Class ProductRepository
 *
 * @package App\Repository
 * @method Product find(string $primary_key_value)
 * @method Product findOrCreate(string $primary_key_value)
 * @method Product findBy(array $where, array $order = [], array $limit = []) : array
 * @method Product[] findAll()
 */
class ProductRepository extends AbstractRepository
{
    public function __construct(ObjectManager $object_manager)
    {
        parent::__construct($object_manager, Product::class);
    }

    public function getFiltered(array $filter, array $limit)
    {
        $adm = $this->getObjectManager()->getObjectDataManager()->getArrayDataManager();
        $query = "SELECT id FROM product ";
        $vendor_ids = $filter["vendor_id"] ?? [];
        $name = $filter["name"] ?? '';
        $where = false;
        if (!empty($vendor_ids)) {
            if (!$where) {
                $query .= " WHERE ";
                $where = true;
            }
            $vendors_query = "(" . implode(",", $vendor_ids) . ")";
            $query .= " vendor_id IN $vendors_query";
        }
        if ($name) {
            if (!$where) {
                $query .= " WHERE ";
                $where = true;
            }else{
                $query.=" AND ";
            }
            $name = $adm->escape($name);
            $query .= " name LIKE '%$name%'";
        }
        if (!empty($limit)) {
            foreach ($limit as $key => $value) {
                $key = (int)$key;
                $value = (int)$value;
                $query .= " LIMIT $key, $value";
                break;
            }
        }

        $result = $adm->query($query);
        if (is_bool($result)) return [];
        $result = $result->fetch_all();
        $arr = [];
        foreach ($result as $value) {
            $value = $value[0];
            $arr[] = $this->find($value);
        }
        return $arr;

    }

    public function getFilteredCount(array $filter)
    {
        $adm = $this->getObjectManager()->getObjectDataManager()->getArrayDataManager();
        $query = "SELECT COUNT(id) as count FROM product ";
        $vendor_ids = $filter["vendor_id"] ?? [];
        $name = $filter["name"] ?? '';
        $where = false;
        if (!empty($vendor_ids)) {
            if (!$where) {
                $query .= " WHERE ";
                $where = true;
            }
            $vendors_query = "(" . implode(",", $vendor_ids) . ")";
            $query .= " vendor_id IN $vendors_query";
        }
        if ($name) {
            if (!$where) {
                $query .= " WHERE ";
                $where = true;
            }else{
                $query.=" AND ";
            }
            $name = $adm->escape($name);
            $query .= " name LIKE '%$name%'";
        }

        $result = $adm->query($query);
        if (is_bool($result)) return [];
        while ($value = $result->fetch_assoc()) {
            $a = $value["count"];
            break;
        }
        return $a;

    }
    public function getWithFlags(array $flag_ids, array $limit = [])
    {
        if (empty($flag_ids)) {
            return $this->findAll();
        }
        $adm = $this->getObjectManager()->getObjectDataManager()->getArrayDataManager();
        $flags = "(" . implode(",", $flag_ids) . ")";

        $query = "SELECT p.id FROM product p LEFT JOIN product_has_flag phf ON p.id = phf.product_id WHERE phf.flag_id in $flags";
        foreach ($limit as $key => $value) {
            $query .= " LIMIT $key, $value";
            break;
        }
        $result = $adm->query($query);
        $a = [];
        if (is_bool($result)) return $a;
        while ($product = $result->fetch_assoc()) {
            $a[] = $this->find($product["id"]);
        }
        return $a;
    }

    public function getByName($product_name, array $limit = [])
    {
        if (!$product_name) return $this->findAll();
        $adm = $this->getObjectManager()->getObjectDataManager()->getArrayDataManager();
        $query = "SELECT id FROM product WHERE name LIKE '%$product_name%'";
        $result = $adm->query($query);
        $a = [];
        while ($product = $result->fetch_assoc()) {
            $a[] = $this->find($product["id"]);
        }
        foreach ($limit as $key => $value) {
            $query .= " LIMIT $key, $value";
            break;
        }
        return $a;
    }
}