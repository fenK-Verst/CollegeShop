<?php


namespace App\Entity\Proxy;

class CustomRouteProxy extends \App\Entity\CustomRoute
{
    private bool $__inited = false;
    private \App\Repository\CustomRouteRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\CustomRoute $parent;

    /**
     * CustomRouteProxy constructor.
     *
     * @param \App\Repository\CustomRouteRepository $repository
     * @param $primaryKeyValue
     */
    public function __construct(\App\Repository\CustomRouteRepository $repository, $primaryKeyValue)
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
    
    public function getLeft() : int
    {
        $this->init();
        return $this->parent->getLeft();           
    }

    public function setLeft(string $left)
    {
        $this->init();
        $this->parent->setLeft($left);           
    }

    public function getRight() : int
    {
        $this->init();
        return $this->parent->getRight();           
    }

    public function setRight(string $right) : void
    {
        $this->init();
        $this->parent->setRight($right);           
    }

    public function getId() : int
    {
        $this->init();
        return $this->parent->getId();           
    }

    public function getShortUrl() : string
    {
        $this->init();
        return $this->parent->getShortUrl();           
    }

    public function setShortUrl(string $url) : void
    {
        $this->init();
        $this->parent->setShortUrl($url);           
    }

    public function getRealUrl() : string
    {
        $this->init();
        return $this->parent->getRealUrl();           
    }

    public function setRealUrl(string $url) : void
    {
        $this->init();
        $this->parent->setRealUrl($url);           
    }

    public function getLvl() : int
    {
        $this->init();
        return $this->parent->getLvl();           
    }

    public function setLvl(int $lvl)
    {
        $this->init();
        $this->parent->setLvl($lvl);           
    }

    public function getIsHidden() : bool
    {
        $this->init();
        return $this->parent->getIsHidden();           
    }

    public function setIsHidden(bool $is_hidden)
    {
        $this->init();
        $this->parent->setIsHidden($is_hidden);           
    }

    public function getTemplate() : ?\App\Entity\Template
    {
        $this->init();
        return $this->parent->getTemplate();           
    }

    public function setTemplate(?\App\Entity\Template $template) : void
    {
        $this->init();
        $this->parent->setTemplate($template);           
    }

    public function getMenu() : ?\App\Entity\Menu
    {
        $this->init();
        return $this->parent->getMenu();           
    }

    public function setMenu(?\App\Entity\Menu $menu) : void
    {
        $this->init();
        $this->parent->setMenu($menu);           
    }

    public function getName() : string
    {
        $this->init();
        return $this->parent->getName();           
    }

    public function setName(string $name) : void
    {
        $this->init();
        $this->parent->setName($name);           
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