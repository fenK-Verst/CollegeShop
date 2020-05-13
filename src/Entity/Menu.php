<?php


namespace App\Entity;

/**
 * Class Menu
 * @Entity(tableName="menu", repositoryClass="App\Repository\MenuRepository")
 *
 * @package App\Entity
 */
class Menu extends AbstractEntity
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
     * @Entity\OneToMany(entity="App\Entity\CustomRoute", primary_key="menu_id")
     */
    protected $routes = [];

    /**
     * @return int
     */
    public function getId() :?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() :?string
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
     **
     * @return array
     */
    public function getRoutes() :?array
    {
        return $this->routes;
    }

    /**
     * @param CustomRoute $route
     */
    public function addRoute(CustomRoute $route)
    {
        if (!in_array($route, (array)$this->routes)) {
            $this->routes[] = $route;
        }
    }
}