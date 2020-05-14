<?php


namespace App\Entity;

/**
 * Class CustomRoute
 * @Entity(tableName="route", repositoryClass="App\Repository\CustomRouteRepository")
 * @package App\Entity
 */
class CustomRoute extends AbstractEntity
{
    /**
     * @Entity\PrimaryKey()
     */
    protected $id;

    /**
     * @Entity\Column()
     */
    protected $short_url;

    /**
     * @Entity\Column()
     */
    protected $real_url;

    /**
     * @Entity\Column()
     */
    protected $name;
    /**
     * @Entity\Column()
     */
    protected $_left;

    /**
     * @Entity\Column()
     */
    protected $_right;

    /**
     * @Entity\Column()
     */
    protected $_lvl;

    /**
     * @Entity\Column()
     */
    protected $is_hidden;

    /**
     * @Entity\Column()
     */
    protected $params;

    /**
     * @Entity\ManyToOne(entity="App\Entity\Template", primary_key="template_id")
     */
    protected $template;

    /**
     * @Entity\ManyToOne(entity="App\Entity\Menu", primary_key="menu_id")
     */
    protected $menu;

    /**
     * @return int|null
     */
    public function getLeft(): ?int
    {
        return $this->_left;
    }

    /**
     * @param string $left
     */
    public function setLeft(string $left)
    {
        $this->_left = $left;
    }

    /**
     * @return int|null
     */
    public function getRight(): ?int
    {
        return $this->_right;
    }

    /**
     * @param string $right
     */
    public function setRight(string $right): void
    {
        $this->_right = $right;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getShortUrl(): ?string
    {
        return $this->short_url;
    }

    /**
     * @param string $url
     */
    public function setShortUrl(string $url): void
    {
        $this->short_url = $url;
    }

    /**
     * @return string
     */
    public function getRealUrl(): ?string
    {
        return $this->real_url;
    }

    /**
     * @param string $url
     */
    public function setRealUrl(string $url): void
    {
        $this->real_url = $url;
    }

    /**
     * @return int|null
     */
    public function getLvl(): ?int
    {
        return $this->_lvl;
    }

    /**
     * @param int $lvl
     */
    public function setLvl(int $lvl)
    {
        $this->_lvl = $lvl;
    }

    /**
     * @return bool|null
     */
    public function getIsHidden(): ?bool
    {
        return $this->is_hidden == 1;
    }

    /**
     * @param bool $is_hidden
     */
    public function setIsHidden(bool $is_hidden)
    {
        $this->is_hidden = $is_hidden ? 1 : 0;
    }

    /**
     * @return mixed
     */
    public function getTemplate() : ?Template
    {
        return $this->template;
    }

    /**
     * @param Template|null $template
     */
    public function setTemplate(?Template $template): void
    {
        $this->template = $template;
    }

    /**
     * @return Menu|null
     */
    public function getMenu() : ?Menu
    {
        return $this->menu;
    }

    /**
     * @param Menu|null $menu
     */
    public function setMenu(?Menu $menu): void
    {
        $this->menu = $menu;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
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
    public function getParams(): ?string
    {
        return $this->params;
    }

    /**
     * @param string $params
     */
    public function setParams(string $params): void
    {
        $this->params = $params;
    }
}