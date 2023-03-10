<?php

namespace App\Entity;

use App\Repository\JournalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=JournalRepository::class)
 * @UniqueEntity("date_checked")
 */
class Journal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", unique=true)
     */
    private $date_checked;
    

    /**
     * @ORM\ManyToOne(targetEntity=User::class, cascade={"remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDateChecked(): ?\DateTimeInterface
    {
        return $this->date_checked;
    }

    public function setDateChecked(\DateTimeInterface $date_checked): self
    {
        $this->date_checked = $date_checked;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
