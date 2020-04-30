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
     * @return array
     */
    public function getProductParam(): array
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
     * @return string|null
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


}