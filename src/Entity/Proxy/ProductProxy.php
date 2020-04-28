<?php


namespace App\Entity\Proxy;


use App\Entity\Flag;
use App\Entity\Folder;
use App\Entity\Vendor;
use App\Repository\ProductRepository;

class ProductProxy extends \App\Entity\Product
{
    private bool $__inited = false;
    private ProductRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\Product $parent;

    /**
     * ProductProxy constructor.
     *
     * @param ProductRepository $repository
     * @param $primaryKey
     */
    public function __construct(ProductRepository $repository, $primaryKeyValue)
    {
        $this->repository = $repository;
        $this->primaryKeyValue = $primaryKeyValue;
    }

    private function init()
    {
        if (!$this->__inited){
            $original = $this->repository->find($this->primaryKeyValue);
            $this->parent = $original;
            $this->__inited = true;
        }
    }
    public function getEntityParams():array
    {
        $this->init();
        return $this->parent->getEntityParams();
    }
    /**
     * @return array
     */
    public function getFolders(): array
    {
        $this->init();
        return $this->parent->getFolders();
    }

    /**
     * @param Folder $folder
     */
    public function addFolder(Folder $folder):void
    {
        $this->init();
        $this->parent->addFolder($folder);
    }

    /**
     * @return array
     */
    public function getFlags(): array
    {
        $this->init();
        return $this->parent->getFlags();
    }

    /**
     * @param Flag $flag
     */
    public function addFlag(Flag $flag): void
    {
        $this->init();
         $this->parent->addFlag($flag);
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        $this->init();
        return $this->parent->getName();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        $this->init();
        return $this->parent->getId();
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->init();
        $this->parent->setName($name);
    }

    /**
     * @return string
     */
    public function getArticle(): string
    {
        $this->init();
        return $this->parent->getArticle();
    }

    /**
     * @param string $article
     */
    public function setArticle(string $article): void
    {
        $this->init();
        $this->parent->setArticle($article);
    }

    /**
     * @return int
     */
    public function getImageId(): ?int
    {
        $this->init();
        return $this->parent->getImageId();
    }

    /**
     * @param int $image_id
     */
    public function setImageId(int $image_id): void
    {
        $this->init();
        $this->parent->setImageId($image_id);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        $this->init();
        return $this->parent->getDescription();
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->init();
        $this->parent->setDescription($description);
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        $this->init();
        return $this->parent->getPrice();
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->init();
        $this->parent->setPrice($price);
    }

    /**
     * @return Vendor|null
     */
    public function getVendor(): ?Vendor
    {
        $this->init();
        return $this->parent->getVendor();
    }

    /**
     * @param Vendor $vendor
     */
    public function setVendor(?Vendor $vendor): void
    {
        $this->init();
        $this->parent->setVendor($vendor);
    }

    /**
     * @param Folder $folder
     */
    public function deleteFolder(Folder $folder)
    {
        $this->init();
        $this->parent->deleteFolder($folder);
    }
}