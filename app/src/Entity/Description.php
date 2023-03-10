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
}
