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
    protected $id;

    /**
     * @Entity\Column()
     */
    protected $name;

    /**
     * @Entity\Column()
     */
    protected $article;

    /**
     * @Entity\Column()
     */
    protected $image_id;

    /**
     * @Entity\Column()
     */
    protected $description;

    /**
     * @Entity\Column()
     */
    protected $price;

    /**
     * @Entity\ManyToOne(entity="App\Entity\Vendor", primary_key="vendor_id")
     */
    protected $vendor;

    /**
     * @Entity\ManyToMany(entity="App\Entity\Folder", self_primary_key="product_id", entity_primary_key="folder_id",table_name="folder_has_product")
     */
    protected $folders = [];

    /**
     * @Entity\ManyToMany(entity="App\Entity\Flag",table_name="product_has_flag", self_primary_key="product_id", entity_primary_key="flag_id")
     */
    protected $flags = [];

    /**
     * @return array
     */
    public function getFolders()
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
    public function getFlags()
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId()
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
    public function getArticle()
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
    public function getImageId()
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
    public function getDescription()
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
    public function getPrice()
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
    public function getVendor()
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