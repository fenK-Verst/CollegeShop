<?php


namespace App\Entity;

/**
 * Class Vendor
 * @Entity(tableName="product_comment", repositoryClass="App\Repository\ProductCommentRepository")
 *
 * @package App\Entity
 */
class ProductComment extends AbstractEntity
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
     * @Entity\Column()
     */
    protected $rating;

    /**
     * @Entity\ManyToOne(entity="App\Entity\Product", primary_key="product_id")
     */
    protected $product;

    /**
     * @Entity\ManyToOne(entity="App\Entity\User", primary_key="user_id")
     */
    protected $user;

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
     * @return float|null
     */
    public function getRating(): ?float
    {
        return $this->rating;
    }

    /**
     * @param float $rating
     */
    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }

    /**
     **
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}