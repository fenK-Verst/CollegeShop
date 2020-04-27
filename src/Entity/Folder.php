<?php


namespace App\Entity;

/**
 * Class Folder
 * @Entity(tableName="folder", repositoryClass="App\Repository\FolderRepository")
 * @package App\Entity
 */
class Folder extends AbstractEntity
{
    /**
     * @Entity\PrimaryKey()
     */
    protected $id;

    /**
     * @Entity\Column()
     */
    protected $name;

    /**
     * @Entity\Column()
     */
    protected $_left;

    /**
     * @Entity\Column()
     */
    protected $_right;

    /**
     * @Entity\Column()
     */
    protected $_lvl;

    /**
     * @Entity\ManyToMany(entity="App\Entity\Product", self_primary_key="folder_id", entity_primary_key="product_id", table_name="folder_has_product")
     */
    protected $products = [];

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        if (!in_array($product, (array)$this->products)) {
            $this->products[] = $product;
        }
    }

    /**
     * @return string
     */
    public function getLeft()
    {
        return $this->_left;
    }

    /**
     * @param string $left
     */
    public function setLeft(string $left)
    {
        $this->_left = $left;
    }

    /**
     * @return string
     */
    public function getRight()
    {
        return $this->_right;
    }

    /**
     * @param string $right
     */
    public function setRight(string $right): void
    {
        $this->_right = $right;
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getLvl()
    {
        return $this->_lvl;
    }
    public function setLvl(int $lvl)
    {
         $this->_lvl = $lvl;
    }

}