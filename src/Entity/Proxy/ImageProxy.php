<?php


namespace App\Entity\Proxy;


use App\Entity\Image;
use App\Entity\Product;
use App\Repository\ImageRepository;

/**
 * Class ImageProxy
 *
 * @package App\Entity\Proxy
 */
class ImageProxy extends Image
{

    private bool $__inited = false;
    private ImageRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\Image $parent;

    /**
     * ImageProxy constructor.
     *
     * @param ImageRepository $repository
     * @param                 $primaryKeyValue
     */
    public function __construct(ImageRepository $repository, $primaryKeyValue)
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

    public function getEntityParams(): array
    {
        $this->init();
        return $this->parent->getEntityParams();
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        $this->init();
        return $this->parent->getProducts();
    }


    /**
     * @param Product $product
     *
     * @return mixed
     */
    public function addProduct(Product $product)
    {
        $this->init();
        return $this->parent->addProduct($product);
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
    public function getPath(): string
    {
        $this->init();
        return $this->parent->getPath();
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->init();
        $this->parent->setPath($path);
    }

    /*
    **
    * @return string
    */
    public function getAlias(): string
    {
        $this->init();
        return $this->parent->getAlias();
    }

    /**
     * @param string $alias
     */
    public function setAlias(string $alias): void
    {
        $this->init();
        $this->parent->setAlias($alias);
    }

}