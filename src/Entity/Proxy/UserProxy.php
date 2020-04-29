<?php


namespace App\Entity\Proxy;

class UserProxy extends \App\Entity\User
{
    private bool $__inited = false;
    private \App\Repository\UserRepository $repository;
    private $primaryKeyValue;
    private \App\Entity\User $parent;

    /**
     * UserProxy constructor.
     *
     * @param \App\Repository\UserRepository $repository
     * @param $primaryKey
     */
    public function __construct(\App\Repository\UserRepository $repository, $primaryKeyValue)
    {
        $this->repository = $repository;
        $this->primaryKeyValue = $primaryKeyValue;
    }

    private function init()
    {
        if (!$this->__inited) {
            $original = $this->repository->find($this->primaryKeyValue);
            $this->parent = $original;
            $this->__inited = true;
        }
    }
    public function getEntityParams():array
    {
        $this->init();
        return $this->parent->getEntityParams();
    }
    
    public function getId()
    {
        $this->init();
        $this->parent->getId();           
    }

    public function getLastname()
    {
        $this->init();
        $this->parent->getLastname();           
    }

    public function setLastname( $lastname) : void
    {
        $this->init();
        $this->parent->setLastname($lastname);           
    }

    public function getFirstname()
    {
        $this->init();
        $this->parent->getFirstname();           
    }

    public function setFirstname( $firstname) : void
    {
        $this->init();
        $this->parent->setFirstname($firstname);           
    }

    public function getEmail()
    {
        $this->init();
        $this->parent->getEmail();           
    }

    public function setEmail( $email) : void
    {
        $this->init();
        $this->parent->setEmail($email);           
    }

    public function getPhone()
    {
        $this->init();
        $this->parent->getPhone();           
    }

    public function setPhone( $phone) : void
    {
        $this->init();
        $this->parent->setPhone($phone);           
    }

    public function getImageId()
    {
        $this->init();
        $this->parent->getImageId();           
    }

    public function setImageId( $image_id) : void
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
        $this->parent->getPassword();           
    }

}