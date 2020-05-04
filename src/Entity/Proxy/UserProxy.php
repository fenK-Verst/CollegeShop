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
//    public function getEntityParams():array
//    {
//        $this->init();
//        return $this->parent->getEntityParams();
//    }
    
    public function getId() : int
    {
        $this->init();
        return $this->parent->getId();           
    }

    public function getLastname() : string
    {
        $this->init();
        return $this->parent->getLastname();           
    }

    public function setLastname( $lastname) : void
    {
        $this->init();
        $this->parent->setLastname($lastname);           
    }

    public function getFirstname() : string
    {
        $this->init();
        return $this->parent->getFirstname();           
    }

    public function setFirstname( $firstname) : void
    {
        $this->init();
        $this->parent->setFirstname($firstname);           
    }

    public function getEmail() : string
    {
        $this->init();
        return $this->parent->getEmail();           
    }

    public function setEmail( $email) : void
    {
        $this->init();
        $this->parent->setEmail($email);           
    }

    public function getPhone() : string
    {
        $this->init();
        return $this->parent->getPhone();           
    }

    public function setPhone( $phone) : void
    {
        $this->init();
        $this->parent->setPhone($phone);           
    }

    public function getImage() : ?\App\Entity\Image
    {
        $this->init();
        return $this->parent->getImage();           
    }

    public function setImage(?\App\Entity\Image $image) : void
    {
        $this->init();
        $this->parent->setImage($image);           
    }

    public function setPassword(string $password)
    {
        $this->init();
        $this->parent->setPassword($password);           
    }

    public function getPassword() : string
    {
        $this->init();
        return $this->parent->getPassword();           
    }

    public function getTableName() : string
    {
        $this->init();
        return $this->parent->getTableName();           
    }

    public function getRepositoryClass() : string
    {
        $this->init();
        return $this->parent->getRepositoryClass();           
    }

    public function getPrimaryKey() : string
    {
        $this->init();
        return $this->parent->getPrimaryKey();           
    }

    public function getColumns() : array
    {
        $this->init();
        return $this->parent->getColumns();           
    }

    public function getEntityParams() : array
    {
        $this->init();
        return $this->parent->getEntityParams();           
    }

    public function getPrimaryKeyValue() : string
    {
        $this->init();
        return $this->parent->getPrimaryKeyValue();           
    }

    public function getColumnValue(string $column) : string
    {
        $this->init();
        return $this->parent->getColumnValue($column);           
    }

    public function getSingleDependencies() : array
    {
        $this->init();
        return $this->parent->getSingleDependencies();           
    }

}