<?php

namespace App\Entity;

use App\Repository\DescriptionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DescriptionRepository::class)
 */
class Description
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Recu::class, inversedBy="descriptions")
     */
    private $descriptions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prices;

    /**
     * @ORM\ManyToOne(targetEntity=Recu::class, inversedBy="descriptionss")
     */
    private $recu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptions(): ?Recu
    {
        return $this->descriptions;
    }

    public function setDescriptions(?Recu $descriptions): self
    {
        $this->descriptions = $descriptions;

        return $this;
    }

    public function getPrices(): ?string
    {
        return $this->prices;
    }

    public function setPrices(string $prices): self
    {
        $this->prices = $prices;

        return $this;
    }

    public function getRecu(): ?Recu
    {
        return $this->recu;
    }

    public function setRecu(?Recu $recu): self
    {
        $this->recu = $recu;

        return $this;
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
}
