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
     * @param $primaryKeyValue
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
//    public function getEntityParams():array
//    {
//        $this->init();
//        return $this->parent->getEntityParams();
//    }
    
    public function getFolders() : array
    {
        $this->init();
        return $this->parent->getFolders();           
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

    public function getFlags() : array
    {
        $this->init();
        return $this->parent->getFlags();           
    }

    public function addFlag(?\App\Entity\Flag $flag) : void
    {
        $this->init();
        $this->parent->addFlag($flag);           
    }

    public function deleteFlag(?\App\Entity\Flag $flag)
    {
        $this->init();
        $this->parent->deleteFlag($flag);           
    }

    public function getComments() : array
    {
        $this->init();
        return $this->parent->getComments();           
    }

    public function addComment(?\App\Entity\ProductComment $comment) : void
    {
        $this->init();
        $this->parent->addComment($comment);           
    }

    public function deleteComment(?\App\Entity\ProductComment $comment)
    {
        $this->init();
        $this->parent->deleteComment($comment);           
    }

    public function getName() : string
    {
        $this->init();
        return $this->parent->getName();           
    }

    public function getId() : int
    {
        $this->init();
        return $this->parent->getId();           
    }

    public function setName(string $name) : void
    {
        $this->init();
        $this->parent->setName($name);           
    }

    public function getArticle() : string
    {
        $this->init();
        return $this->parent->getArticle();           
    }

    public function setArticle(string $article) : void
    {
        $this->init();
        $this->parent->setArticle($article);           
    }

    public function getImage() : ?\App\Entity\Image
    {
        $this->init();
        return $this->parent->getImage();           
    }

    public function setImage(?\App\Entity\Image $image) : void
    {
        $this->init();
        $this->parent->setImage($image);           
    }

    public function getDescription() : string
    {
        $this->init();
        return $this->parent->getDescription();           
    }

    public function setDescription(string $description) : void
    {
        $this->init();
        $this->parent->setDescription($description);           
    }

    public function getPrice() : float
    {
        $this->init();
        return $this->parent->getPrice();           
    }

    public function setPrice(float $price) : void
    {
        $this->init();
        $this->parent->setPrice($price);           
    }

    public function getCount() : int
    {
        $this->init();
        return $this->parent->getCount();           
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

    public function getParamValues() : array
    {
        $this->init();
        return $this->parent->getParamValues();           
    }

    public function addParamValue(?\App\Entity\ProductParamValue $value)
    {
        $this->init();
        $this->parent->addParamValue($value);           
    }

    public function getTableName() : string
    {
        $this->init();
        return $this->parent->getTableName();           
    }

    public function getRepositoryClass() : string
    {
        $this->init();
        return $this->parent->getRepositoryClass();           
    }

    public function getPrimaryKey() : string
    {
        $this->init();
        return $this->parent->getPrimaryKey();           
    }

    public function getColumns() : array
    {
        $this->init();
        return $this->parent->getColumns();           
    }

    public function getEntityParams() : array
    {
        $this->init();
        return $this->parent->getEntityParams();           
    }

    public function getPrimaryKeyValue() : string
    {
        $this->init();
        return $this->parent->getPrimaryKeyValue();           
    }

    public function getColumnValue(string $column) : string
    {
        $this->init();
        return $this->parent->getColumnValue($column);           
    }

    public function getSingleDependencies() : array
    {
        $this->init();
        return $this->parent->getSingleDependencies();           
    }

}