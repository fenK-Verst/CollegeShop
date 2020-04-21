<?php


namespace App\Entity;

/**
 * Class Folder
 * @Entity(tableName="folder", repositoryClass="App\Repository\FolderRepository")
 * @package App\Entity
 */
class Folder extends AbstractEntity
{
    /**
     * @Entity\PrimaryKey()
     * @Entity\Column()
     */
    private int $id;

    /**
     * @Entity\Column()
     */
    private string $name;

    /**
     * @Entity\Column()
     */
    private string $left;

    /**
     * @Entity\Column()
     */
    private string $right;

    /**
     * @return string
     */
    public function getLeft(): string
    {
        return $this->left;
    }

    /**
     * @param string $left
     */
    public function setLeft(string $left): void
    {
        $this->left = $left;
    }

    /**
     * @return string
     */
    public function getRight(): string
    {
        return $this->right;
    }

    /**
     * @param string $right
     */
    public function setRight(string $right): void
    {
        $this->right = $right;
    }
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
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


}