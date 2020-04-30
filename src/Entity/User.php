<?php


namespace App\Entity;

/**
 * Class User
 *
 * @Entity(tableName="user", repositoryClass="App\Repository\UserRepository")
 * @package App\Entity
 */
class User extends AbstractEntity
{
    /**
     * @Entity\PrimaryKey()
     */
    protected $id;

    /**
     * @Entity\Column()
     */
    protected $lastname;

    /**
     * @Entity\Column()
     */
    protected $firstname;

    /**
     * @Entity\Column()
     */
    protected $email;

    /**
     * @Entity\Column()
     */
    protected $phone;

    /**
     * @Entity\Column()
     */
    protected $image_id;

    /**
     * @Entity\Column()
     */
    protected $password;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }


    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }


    public function getImageId(): ?int
    {
        return $this->image_id;
    }

    /**
     * @param mixed $image_id
     */
    public function setImageId($image_id): void
    {
        $this->image_id = $image_id;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}