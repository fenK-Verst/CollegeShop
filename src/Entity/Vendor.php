<?php


namespace App\Entity;

/**
 * Class Vendor
 * @Entity(tableName="vendor", repositoryClass="App\Repository\VendorRepository")
 *
 * @package App\Entity
 */
class Vendor extends AbstractEntity
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
     * @Entity\OneToMany(entity="App\Model\Product", primary_key="vendor_id")
     */
    private array $products;

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

    /**
     **
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
}