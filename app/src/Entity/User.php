<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;




/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity
 * (
 *  fields={"username"},
 *  message="L'utilisateur existe déjà"
 * )
 */
class User implements UserInterface
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
     *   minMessage="Votre identifiant doit être composé d'au moins 3 caractères"
     * )
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=8)
     * @Assert\EqualTo(propertyPath="confirmPassword", message="Votre mot de passe n'est pas identique")
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
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $isOnline = false;
    /**
     * @Assert\Length(min=8)
     */
    private $confirmPassword;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername( string $username ): self
    {
        $this->username = $username;

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

    public function getIsOnline(): ?bool
    {
        return $this->isOnline;
    }

    public function setIsOnline( bool $isOnline ): self
    {
        $this->isOnline = $isOnline;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }

    public function getSalt(){}
    public function getRoles(){return array('ROLE_USER');}
    public function eraseCredentials(){}

}




