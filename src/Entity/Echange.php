<?php

namespace App\Entity;

use App\Repository\EchangeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EchangeRepository::class)
 */
class Echange
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Permanence::class, inversedBy="echanges")
     * @ORM\JoinColumn(nullable=false)
     */
    private $permanence;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="echanges")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=EchangePropos::class, mappedBy="echange", orphanRemoval=true)
     */
    private $echangePropos;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codeValidate;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $resolue;

    /**
     * @ORM\Column(type="date")
     */
    private $created_at;

    public function __construct()
    {
        $this->echangePropos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|EchangePropos[]
     */
    public function getEchangePropos(): Collection
    {
        return $this->echangePropos;
    }

    public function addEchangePropo(EchangePropos $echangePropo): self
    {
        if (!$this->echangePropos->contains($echangePropo)) {
            $this->echangePropos[] = $echangePropo;
            $echangePropo->setEchange($this);
        }

        return $this;
    }

    public function removeEchangePropo(EchangePropos $echangePropo): self
    {
        if ($this->echangePropos->contains($echangePropo)) {
            $this->echangePropos->removeElement($echangePropo);
            // set the owning side to null (unless already changed)
            if ($echangePropo->getEchange() === $this) {
                $echangePropo->setEchange(null);
            }
        }

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

    public function getResolue(): ?bool
    {
        return $this->resolue;
    }

    public function setResolue(bool $resolue): self
    {
        $this->resolue = $resolue;

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
