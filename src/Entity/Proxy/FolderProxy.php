<?php


namespace App\Entity\Proxy;


use App\Entity\Product;
use App\Repository\FolderRepository;

class FolderProxy extends \App\Entity\Folder
{
    private bool $__inited = false;
    private FolderRepository $repository;
    private $primaryKey;
    private \App\Entity\Folder $parent;

    /**
     * FolderProxy constructor.
     *
     * @param FolderRepository $repository
     * @param $primaryKey
     */
    public function __construct(FolderRepository $repository, $primaryKey)
    {
        $this->repository = $repository;
        $this->primaryKey = $primaryKey;
    }

    private function init()
    {
        if (!$this->__inited){
            $original = $this->repository->find($this->primaryKey);
            $this->parent = $original;
            $this->__inited = true;
        }
    }

    public function getProducts(): array
    {
        $this->init();
        return $this->parent->getProducts();
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $this->init();
        $this->parent->addProduct($product);

    }

    /**
     * @return string
     */
    public function getLeft(): string
    {
        $this->init();
        return $this->parent->getLeft();
    }

    /**
     * @param string $left
     */
    public function setLeft(string $left): void
    {
        $this->init();
        $this->parent->setLeft($left);
    }

    /**
     * @return string
     */
    public function getRight(): string
    {
        $this->init();
        return $this->parent->getRight();
    }

    /**
     * @param string $right
     */
    public function setRight(string $right): void
    {
        $this->init();
        $this->parent->setRight($right);
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
     * @return string
     */
    public function getName(): string
    {
        $this->init();
        return $this->parent->getName();
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->init();
        $this->parent->setName($name);
    }
}