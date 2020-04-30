<?php


namespace App\Entity;

/**
 * Class Flag
 * @Entity(tableName="flag", repositoryClass="App\Repository\FlagRepository")
 * @package App\Entity
 */
class Flag extends AbstractEntity
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
     * @Entity\ManyToMany(entity="App\Entity\Product",table_name="product_has_flag" self_primary_key="flag_id",entity_primary_key="product_id")
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
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
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