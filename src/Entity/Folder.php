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
    protected $id = 1;
}