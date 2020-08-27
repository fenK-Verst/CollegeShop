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
     * @Entity\ManyToOne(entity="App\Entity\Image", primary_key="image_id")
     */
    protected $image;

    /**
     * @Entity\Column()
     */
    protected $password;

    /**
     * @Entity\OneToMany(entity="App\Entity\Stonk", primary_key="user_id")
     */
    protected $stonks = [];
    
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


    public function getImage(): ?Image
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage(?Image $image): void
    {
        if ($image) $image->setType("avatar");
        $this->image = $image;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     **
     * @return array
     */
    public function getStonks(): ?array
    {
        return $this->stonks;
    }

    /**
     * @param Stonk $stonk
     */
    public function addStonk(Stonk $stonk): void
    {
        $finded = false;
        foreach ($this->stonks as $this_stonk) {
            if ($stonk->getId() == $this_stonk->getId()) {
                $finded = true;
                break;
            }
        }
        if (!$finded) {
            $this->stonks[] = $stonk;
        }
    }

    /**
     * @param Stonk $stonk
     */
    public function deleteStonk(Stonk $stonk)
    {
        foreach ($this->stonks as $key => $this_stonk) {
            if ($stonk->getId() == $this_stonk->getId()) {
                unset($this->stonks[$key]);
            }
        }

    }
}