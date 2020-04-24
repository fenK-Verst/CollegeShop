<?php


namespace App\Entity;


class User extends AbstractEntity
{
    /**
     * @Entity\PrimaryKey()
     * @Entity\Column()
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

    
    public function getId()
    {
        return $this->id;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getFirstname()
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

    
    public function getEmail()
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

    
    public function getPhone()
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

    
    public function getImageId()
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
}