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
     * @Entity\Column()
     */
    private int $id;

    /**
     * @Entity\Column()
     */
    private string $name;

    /**
     * @Entity\Column()
     */
    private string $left;

    /**
     * @Entity\Column()
     */
    private string $right;

    /**
     * @Entity\ManyToMany(entity="App\Model\Product", self_primary_key="folder_id", entity_primary_key="product_id", table_name="folder_has_product")
     */
    private array $products;

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
    public function getLeft(): string
    {
        return $this->left;
    }

    /**
     * @param string $left
     */
    public function setLeft(string $left): void
    {
        $this->left = $left;
    }

    /**
     * @return string
     */
    public function getRight(): string
    {
        return $this->right;
    }

    /**
     * @param string $right
     */
    public function setRight(string $right): void
    {
        $this->right = $right;
    }
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
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


}