<?php


namespace App\Entity;

/**
 * Class Product
 * @Entity(tableName="product", repositoryClass="App\Repository\ProductRepository")
 *
 * @package App\Entity
 */
class Product extends AbstractEntity
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
    private string $article;

    /**
     * @Entity\Column()
     */
    private ?int $image_id;

    /**
     * @Entity\Column()
     */
    private string $description;

    /**
     * @Entity\Column()
     */
    private float $price;

    /**
     * @Entity\ManyToOne(entity="App\Model\Vendor", primary_key="vendor_id")
     */
    private Vendor $vendor;

    /**
     * @Entity\ManyToMany(entity="App\Model\Folder", self_primary_key="product_id", entity_primary_key="folder_id",table_name="folder_has_product")
     */
    private array $folders;

    /**
     * @Entity\ManyToMany(entity="App\Model\Flag", self_primary_key="product_id", entity_primary_key="flag_id")
     */
    private array $flags;

    /**
     * @return array
     */
    public function getFolders(): array
    {
        return $this->folders;
    }

    /**
     * @param Folder $folder
     */
    public function addFolder(Folder $folder)
    {
        if (!in_array($folder, (array)$this->folders)) {
            $this->folders[] = $folder;
        }
    }

    /**
     * @return array
     */
    public function getFlags(): array
    {
        return $this->flags;
    }

    /**
     * @param Flag $flag
     */
    public function addFlag(Flag $flag): void
    {
        if (!in_array($flag, (array)$this->flags)) {
            $this->flags[] = $flag;
        }
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getArticle(): string
    {
        return $this->article;
    }

    /**
     * @param string $article
     */
    public function setArticle(string $article): void
    {
        $this->article = $article;
    }

    /**
     * @return int
     */
    public function getImageId(): ?int
    {
        return $this->image_id;
    }

    /**
     * @param int $image_id
     */
    public function setImageId(int $image_id): void
    {
        $this->image_id = $image_id;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return Vendor|null
     */
    public function getVendor(): ?Vendor
    {
        return $this->vendor;
    }

    /**
     * @param Vendor $vendor
     */
    public function setVendor(Vendor $vendor): void
    {
        $this->vendor = $vendor;
    }

}