<?php

namespace App\Entity;


use App\Repository\RecuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecuRepository::class)
 */
class Recu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=Description::class, mappedBy="descriptions")
     */
    private $descriptions;

    /**
     * @ORM\OneToMany(targetEntity=Description::class, mappedBy="recu")
     */
    private $descriptionss;

    public function __construct()
    {
        $this->descriptions = new ArrayCollection();
        $this->descriptionss = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Description>
     */
    public function getDescriptions(): Collection
    {
        return $this->descriptions;
    }

    public function addDescription(Description $description): self
    {
        if (!$this->descriptions->contains($description)) {
            $this->descriptions[] = $description;
            $description->setDescriptions($this);
        }

        return $this;
    }

    public function removeDescription(Description $description): self
    {
        if ($this->descriptions->removeElement($description)) {
            // set the owning side to null (unless already changed)
            if ($description->getDescriptions() === $this) {
                $description->setDescriptions(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Description>
     */
    public function getDescriptionss(): Collection
    {
        return $this->descriptionss;
    }

    public function addDescriptionss(Description $descriptionss): self
    {
        if (!$this->descriptionss->contains($descriptionss)) {
            $this->descriptionss[] = $descriptionss;
            $descriptionss->setRecu($this);
        }

        return $this;
    }

    public function removeDescriptionss(Description $descriptionss): self
    {
        if ($this->descriptionss->removeElement($descriptionss)) {
            // set the owning side to null (unless already changed)
            if ($descriptionss->getRecu() === $this) {
                $descriptionss->setRecu(null);
            }
        }

        return $this;
    }
}
