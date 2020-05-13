<?php


namespace App\Entity;

/**
 * Class Template
 * @Entity(tableName="template", repositoryClass="App\Repository\TemplateRepository")
 *
 * @package App\Entity
 */
class Template extends AbstractEntity
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
    protected $path;

    /**
     * @Entity\OneToMany(entity="App\Entity\Route", primary_key="menu_id")
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
     * @return string
     */
    public function getPath() :?string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path): void
    {
        $this->path = $path;
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