<?php


namespace App\Entity;

/**
 * Class SiteParams
 * @Entity(tableName="site_params", repositoryClass="App\Repository\SiteParamsRepository")
 *
 * @package App\Entity
 */
class SiteParams extends AbstractEntity
{
    /**
     * @Entity\PrimaryKey()
     */
    protected $id;

    /**
     * @Entity\Column()
     */
    protected $vars;

    /**
     * @Entity\Column()
     */
    protected $params;


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
    public function getVars(): ?string
    {
        return $this->vars;
    }

    /**
     * @param string $vars
     */
    public function setVars(string $vars): void
    {
        $this->vars = $vars;
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
