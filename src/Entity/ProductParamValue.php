<?php


namespace App\Entity;

/**
 * Class ProductParamValue
 * @Entity(tableName="product_param_value", repositoryClass="App\Repository\ProductParamValueRepository")
 *
 * @package App\Entity
 */
class ProductParamValue extends AbstractEntity
{
    /**
     * @Entity\PrimaryKey()
     */
    protected $id;

    /**
     * @Entity\Column()
     */
    protected $value;


    /**
     * @Entity\ManyToOne(entity="App\Entity\ProductParam", primary_key="param_id")
     */
    protected $productParam;

    /**
     * @Entity\ManyToOne(entity="App\Entity\Product", primary_key="product_id")
     */
    protected $product;

    /**
     * @return array
     */
    public function getProductParam(): ?ProductParam
    {
        return $this->productParam;
    }

    /**
     * @param ProductParam $productParam
     */
    public function setProductParam(ProductParam $productParam)
    {
        $this->productParam = $productParam;
    }


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @return Product|null
     */
    public function getProduct():?Product
    {
        return $this->product;
    }

    /**
     * @param Product $vendor
     */
    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }

}