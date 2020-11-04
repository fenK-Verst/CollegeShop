<?php


namespace App\Entity;

/**
 * Class Image
 * @Entity(tableName="image", repositoryClass="App\Repository\ImageRepository")
 *
 * @package App\Entity
 */
class Image extends AbstractEntity
{
    /**
     * @Entity\PrimaryKey()
     */
    protected $id;

    /**
     * @Entity\Column()
     */
    protected $alias;

    /**
     * @Entity\Column()
     */
    protected $path;

    /**
     * @Entity\Column()
     */
    protected $type;

    public static $PRODUCT_TYPE = 'product';
    public static $AVATAR_TYPE = 'avatar';

    /**
     * @Entity\OneToMany(entity="App\Entity\Product", primary_key="image_id")
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
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string $name
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    /*
    **
    * @return string
    */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @param string $name
     */
    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        if (in_array($type, [self::$AVATAR_TYPE, self::$PRODUCT_TYPE])) {
            $this->type = $type;
        }
    }

}
