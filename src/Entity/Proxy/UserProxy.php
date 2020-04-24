<?php


namespace App\Entity\Proxy;


use App\Entity\User;
use App\Repository\UserRepository;

class UserProxy extends User
{

    private bool $__inited = false;
    private UserRepository $repository;
    private $primaryKey;
    /**
     * @var User
     */
    private User $parent;

    /**
     * UserProxy constructor.
     *
     * @param UserRepository $repository
     * @param $primaryKey
     */
    public function __construct(UserRepository $repository, $primaryKey)
    {
        $this->repository = $repository;
        $this->primaryKey = $primaryKey;
    }

    private function init()
    {
        if (!$this->__inited){
            $original = $this->repository->find($this->primaryKey);
            $this->parent = $original;
            $this->__inited = true;
        }
    }
    public function getId()
    {
        $this->init();
        return $this->parent->getId;
    }

    public function getLastname()
    {
        $this->init();
        return $this->parent->getLastname();
    }

    public function setLastname($lastname): void
    {
        $this->init();
        $this->parent->setLastname($lastname);
    }

    public function getFirstname()
    {
        $this->init();
        return $this->parent->getFirstname();
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->init();
        $this->parent->setFirstname($firstname);
    }

    
    public function getEmail()
    {
        $this->init();
        return $this->parent->getEmail();
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->init();
        $this->parent->setEmail($email);
    }

    
    public function getPhone()
    {
        $this->init();
        return $this->parent->getPhone();
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->init();
        $this->parent->setPhone($phone);
    }

    
    public function getImageId()
    {
        $this->init();
        return $this->parent->getImageId();
    }

    /**
     * @param mixed $image_id
     */
    public function setImageId($image_id): void
    {
        $this->init();
        $this->parent->setImageId($image_id);
    }

    public function setPassword(string $password)
    {
        $this->init();
        $this->parent->setPassword($password);
    }
    public function getPassword()
    {
        $this->init();
        return $this->parent->getPassword();
    }
}