<?php


namespace App\Entity;

/**
 * Class Stonk
 * @Entity(tableName="stonk", repositoryClass="App\Repository\StonkRepository")
 *
 * @package App\Entity
 */
class Stonk extends AbstractEntity
{
    /**
     * @Entity\PrimaryKey()
     */
    protected $id;

    /**
     * @Entity\Column()
     */
    protected $title;

    /**
     * @Entity\Column()
     */
    protected $description;

    /**
     * @Entity\Column()
     */
    protected $summ;

    /**
     * @Entity\Column()
     */
    protected $created_at;

    /**
     * @Entity\ManyToOne(entity="App\Entity\User", primary_key="user_id")
     */
    protected $user;

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
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getSumm(): float
    {
        return $this->summ;
    }

    /**
     * @param float $summ
     */
    public function setSumm(float $summ): void
    {
        $this->summ = $summ;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return ?User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param ?User $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

}