<?php


namespace App\Entity;

/**
 * Class ProductParam
 * @Entity(tableName="product_param", repositoryClass="App\Repository\ProductParamRepository")
 * @package App\Entity
 */
class ProductParam extends AbstractEntity
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
     * @Entity\OneToMany(entity="App\Entity\ProductParamValue", primary_key="param_id")
     */
    protected $productParamValues = [];

    /**
     * @return array
     */
    public function getProductParamValues(): array
    {
        return $this->productParamValues;
    }

    /**
     * @param ProductParamValue $product_param_value
     */
    public function addProductParamValue(ProductParamValue $product_param_value)
    {
        if (!in_array($product_param_value, (array)$this->productParamValues)) {
            $this->productParamValues[] = $product_param_value;
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