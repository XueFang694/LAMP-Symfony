<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;





/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *   min=3,
     *   minMessage="Votre login doit être composé d'au moins 3 caractères"
     * )
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastConnect;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UsersGroup", inversedBy="users")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $isOnline;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin( string $login ): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword( string $password ): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname( string $firstname ): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname( string $lastname ): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt( \DateTimeInterface $createdAt ): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLastConnect(): ?\DateTimeInterface
    {
        return $this->lastConnect;
    }

    public function setLastConnect( \DateTimeInterface $lastConnect ): self
    {
        $this->lastConnect = $lastConnect;

        return $this;
    }

    public function getUser(): ?UsersGroup
    {
        return $this->user;
    }

    public function setUser( ?UsersGroup $user ): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIsOnline(): ?bool
    {
        return $this->isOnline;
    }

    public function setIsOnline( bool $isOnline ): self
    {
        $this->isOnline = $isOnline;

        return $this;
    }

}




