<?php

namespace App\Entity;

use App\Repository\EchangeProposRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EchangeProposRepository::class)
 */
class EchangePropos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Echange::class, inversedBy="echangePropos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $echange;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="echangePropos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeValidate;

    /**
     * @ORM\Column(type="date")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEchange(): ?Echange
    {
        return $this->echange;
    }

    public function setEchange(?Echange $echange): self
    {
        $this->echange = $echange;

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

    public function getCodeValidate(): ?string
    {
        return $this->codeValidate;
    }

    public function setCodeValidate(string $codeValidate): self
    {
        $this->codeValidate = $codeValidate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
