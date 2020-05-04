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
     * @Entity\ManyToOne(entity="App\Entity\Image", primary_key="image_id")
     */
    protected $image;

    /**
     * @Entity\Column()
     */
    protected $description;

    /**
     * @Entity\Column()
     */
    protected $price;

    /**
     * @Entity\Column()
     */
    protected $count;

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
     * @Entity\OneToMany(entity="App\Entity\ProductParamValue", primary_key="product_id")
     */
    protected $paramValues = [];

    /**
     * @return array
     */
    public function getFolders(): ?array
    {
        return $this->folders;
    }

    /**
     * @param Folder $folder
     */
    public function addFolder(Folder $folder)
    {
        $finded = false;
        foreach ($this->folders as $this_folder) {
            if ($folder->getId() == $this_folder->getId()) {
                $finded = true;
                break;
            }
        }
        if (!$finded) {
            $this->folders[] = $folder;
        }
    }

    /**
     * @param Folder $folder
     */
    public function deleteFolder(Folder $folder)
    {
        foreach ($this->folders as $key => $this_folder) {
            if ($folder->getId() == $this_folder->getId()) {
                unset($this->folders[$key]);
            }
        }

    }

    /**
     * @return array
     */
    public function getFlags(): ?array
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): ?int
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
    public function getArticle(): ?string
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
     * @return Image
     */
    public function getImage(): ?Image
    {
        return $this->image;
    }

    /**
     * @param Image|null $image
     */
    public function setImage(?Image $image): void
    {
        if ($image) $image->setType("avatar");
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
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
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return Vendor|null
     */
    public function getVendor():?Vendor
    {
        return $this->vendor;
    }

    /**
     * @param Vendor $vendor
     */
    public function setVendor(?Vendor $vendor): void
    {
        $this->vendor = $vendor;
    }

    /**
     **
     * @return array
     */
    public function getParamValues() :?array
    {
        return $this->paramValues;
    }

    /**
     * @param ProductParamValue $value
     */
    public function addParamValue(ProductParamValue $value)
    {
        if (!in_array($value, (array)$this->paramValues)) {
            $this->paramValues[] = $value;
        }
    }
}