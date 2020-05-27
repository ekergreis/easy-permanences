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
     * @ORM\ManyToOne(targetEntity=Permanence::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $permanence;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="echangePropos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code_validate;

    /**
     * @ORM\Column(type="date")
     */
    private $created_at;

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

    public function getPermanence(): ?Permanence
    {
        return $this->permanence;
    }

    public function setPermanence(?Permanence $permanence): self
    {
        $this->permanence = $permanence;

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
        return $this->code_validate;
    }

    public function setCodeValidate(string $code_validate): self
    {
        $this->code_validate = $code_validate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
