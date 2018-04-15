<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    public $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    public $password;

    /**
     * @ORM\Column(type="string", length=254, unique=true)
     */
    public $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    public $isActive;

    /**
     * @ORM\OneToOne(
     *      targetEntity="App\Entity\UserProfile",
     *      mappedBy="user",
     *      orphanRemoval=true,
     *      cascade={"persist"}
     * )
     */
    private $profile;

    public function __construct()
    {
        $this->isActive = true;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProfile(): UserProfile
    {
        return $this->profile;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->username;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getSalt()
    {
        return null;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    public function setProfile(UserProfile $profile): void
    {
        $profile->setUser($this);
        $this->profile = $profile;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password
        ) = unserialize($serialized, ['allowed_classes' => false]);
    }
}
