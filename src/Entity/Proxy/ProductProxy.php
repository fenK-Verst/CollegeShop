<?php


namespace App\Entity\Proxy;


use App\Entity\Flag;
use App\Entity\Folder;
use App\Entity\Vendor;

class ProductProxy extends \App\Entity\Product
{
    private bool $__inited = false;

    public function __construct()
    {

    }

    private function init()
    {
        $this->__inited = true;
    }

    /**
     * @return array
     */
    public function getFolders(): array
    {
        if (!$this->__inited) $this->init();
        return parent::getFolders();
    }

    /**
     * @param Folder $folder
     */
    public function addFolder(Folder $folder):void
    {
        if (!$this->__inited) $this->init();
        parent::addFolder($folder);
    }

    /**
     * @return array
     */
    public function getFlags(): array
    {
        if (!$this->__inited) $this->init();
        return parent::getFlags();
    }

    /**
     * @param Flag $flag
     */
    public function addFlag(Flag $flag): void
    {
        if (!$this->__inited) $this->init();
         parent::addFlag($flag);
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        if (!$this->__inited) $this->init();
        return parent::getName();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        if (!$this->__inited) $this->init();
        return parent::getId();
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        if (!$this->__inited) $this->init();
        parent::setName($name);
    }

    /**
     * @return string
     */
    public function getArticle(): string
    {
        if (!$this->__inited) $this->init();
        return parent::getArticle();
    }

    /**
     * @param string $article
     */
    public function setArticle(string $article): void
    {
        if (!$this->__inited) $this->init();
        parent::setArticle($article);
    }

    /**
     * @return int
     */
    public function getImageId(): ?int
    {
        if (!$this->__inited) $this->init();
        return parent::getImageId();
    }

    /**
     * @param int $image_id
     */
    public function setImageId(int $image_id): void
    {
        if (!$this->__inited) $this->init();
        parent::setImageId($image_id);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        if (!$this->__inited) $this->init();
        return parent::getDescription();
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        if (!$this->__inited) $this->init();
        parent::setDescription($description);
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        if (!$this->__inited) $this->init();
        return parent::getPrice();
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        if (!$this->__inited) $this->init();
        parent::setPrice($price);
    }

    /**
     * @return Vendor|null
     */
    public function getVendor(): ?Vendor
    {
        if (!$this->__inited) $this->init();
        return parent::getVendor();
    }

    /**
     * @param Vendor $vendor
     */
    public function setVendor(Vendor $vendor): void
    {
        if (!$this->__inited) $this->init();
        parent::setVendor($vendor);
    }
}