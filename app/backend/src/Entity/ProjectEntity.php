<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ProjectEntityRepository")
 * @UniqueEntity(
 *     fields={"label", "categoryEntity"},
 *     errorPath="port",
 *     message="Un projet avec le meme nom existe pour cette categorie. ({{ value }})"
 * )
 * @author  Geoffrey LEVENEZ
 */
class ProjectEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string Le nom du projet
     * 
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 8, minMessage = "Le nom du projet est trop court.",
     *      max = 255, maxMessage = "Le nom du projet est trop long."
     * )
     * @Assert\NotBlank( message="La valeur 'label' ne peut etre vide" )
     * @Assert\Type(
     *      type="string",
     *      message="La valeur {{ value }} n'est pas de type chaine de caractere."
     * )
     */
    private $label;
    
    /**
     * @var File Le fichier shell (.sh) d'amorce du projet.
     * 
     * @Assert\File(
     *     mimeTypes = {"application/x-sh"},
     *     mimeTypesMessage = "Merci de charger un fichier Shell (.sh)"
     * )
     */
    protected $bootstrap;

    /**
     * @var array liste les dependances aux serveurs.
     *            Exemple : [ "PROD-ESL", "NAS2-PRODESL" ]
     * 
     * @ORM\Column(type="array", nullable=true)
     */
    private $networkDependencies = [];

    /**
     * @var string Le descriptif pour expliquer le principe du projet.
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank( message="La valeur 'documentation' ne peut etre vide." )
     * @Assert\Length(
     *      min = 8, minMessage = "Votre documentation est trop courte."
     * )
     */
    private $documentation;

    /**
     * @var array Tableau qui contient une liste de parametres/arguments a envoyer pour executer l'automatisme contenu dans le projet
     * 
     * @ORM\Column(type="array", nullable=true)
     * TODO | Ce parametrage est pour le moment trop libre, n'importe quel type de donnee peut etre inseree et il est difficile d'en connaitre le type.
     */
    private $inputs = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoryEntity", inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoryEntity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function setBoostrap(File $file = null)
    {
        $this->bootstrap = $file;
    }

    public function getBootstrap()
    {
        return $this->bootstrap;
    }

    public function getNetworkDependencies(): ?array
    {
        return $this->networkDependencies;
    }

    public function setNetworkDependencies(?array $networkDependencies): self
    {
        $this->networkDependencies = $networkDependencies;

        return $this;
    }

    public function getDocumentation(): ?string
    {
        return $this->documentation;
    }

    public function setDocumentation(string $documentation): self
    {
        $this->documentation = $documentation;

        return $this;
    }

    public function getInputs(): ?array
    {
        return $this->inputs;
    }

    public function setInputs(?array $inputs): self
    {
        $this->inputs = $inputs;

        return $this;
    }

    public function getCategoryEntity(): ?CategoryEntity
    {
        return $this->categoryEntity;
    }

    public function setCategoryEntity(?CategoryEntity $categoryEntity): self
    {
        $this->categoryEntity = $categoryEntity;

        return $this;
    }
}
