<?php


namespace App\Entity\Proxy;

class ProductProxy extends \App\Entity\Product
{
    private bool $__inited = false;
    private \App\Repository\ProductRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\Product $parent;

    /**
     * ProductProxy constructor.
     *
     * @param \App\Repository\ProductRepository $repository
     * @param $primaryKey
     */
    public function __construct(\App\Repository\ProductRepository $repository, $primaryKeyValue)
    {
        $this->repository = $repository;
        $this->primaryKeyValue = $primaryKeyValue;
    }

    private function init()
    {
        if (!$this->__inited) {
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
    
    public function getFolders()
    {
        $this->init();
        $this->parent->getFolders();           
    }

    public function addFolder(?\App\Entity\Folder $folder)
    {
        $this->init();
        $this->parent->addFolder($folder);           
    }

    public function deleteFolder(?\App\Entity\Folder $folder)
    {
        $this->init();
        $this->parent->deleteFolder($folder);           
    }

    public function getFlags()
    {
        $this->init();
        $this->parent->getFlags();           
    }

    public function addFlag(?\App\Entity\Flag $flag) : void
    {
        $this->init();
        $this->parent->addFlag($flag);           
    }

    public function getName()
    {
        $this->init();
        $this->parent->getName();           
    }

    public function getId()
    {
        $this->init();
        $this->parent->getId();           
    }

    public function setName(string $name) : void
    {
        $this->init();
        $this->parent->setName($name);           
    }

    public function getArticle()
    {
        $this->init();
        $this->parent->getArticle();           
    }

    public function setArticle(string $article) : void
    {
        $this->init();
        $this->parent->setArticle($article);           
    }

    public function getImage()
    {
        $this->init();
        $this->parent->getImage();           
    }

    public function setImage(?\App\Entity\Image $image) : void
    {
        $this->init();
        $this->parent->setImage($image);           
    }

    public function getDescription()
    {
        $this->init();
        $this->parent->getDescription();           
    }

    public function setDescription(string $description) : void
    {
        $this->init();
        $this->parent->setDescription($description);           
    }

    public function getPrice()
    {
        $this->init();
        $this->parent->getPrice();           
    }

    public function setPrice(float $price) : void
    {
        $this->init();
        $this->parent->setPrice($price);           
    }

    public function getCount()
    {
        $this->init();
        $this->parent->getCount();           
    }

    public function setCount(int $count) : void
    {
        $this->init();
        $this->parent->setCount($count);           
    }

    public function getVendor() : ?\App\Entity\Vendor
    {
        $this->init();
        return $this->parent->getVendor();           
    }

    public function setVendor(?\App\Entity\Vendor $vendor) : void
    {
        $this->init();
        $this->parent->setVendor($vendor);           
    }

}