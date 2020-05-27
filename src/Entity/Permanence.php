<?php

namespace App\Entity;

use App\Repository\PermanenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PermanenceRepository::class)
 */
class Permanence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="user_permanence")
     */
    private $group_permanence;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="permanences")
     */
    private $user_permanence;

    /**
     * @ORM\OneToMany(targetEntity=Echange::class, mappedBy="permanence", orphanRemoval=true)
     */
    private $echanges;

    /**
     * @ORM\OneToMany(targetEntity=EchangePropos::class, mappedBy="echange", orphanRemoval=true)
     */
    private $echangePropos;

    public function __construct()
    {
        $this->user_permanence = new ArrayCollection();
        $this->echanges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getGroupPermanence(): ?Group
    {
        return $this->group_permanence;
    }

    public function setGroupPermanence(?Group $group_permanence): self
    {
        $this->group_permanence = $group_permanence;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserPermanence(): Collection
    {
        return $this->user_permanence;
    }

    public function addUserPermanence(User $userPermanence): self
    {
        if (!$this->user_permanence->contains($userPermanence)) {
            $this->user_permanence[] = $userPermanence;
        }

        return $this;
    }

    public function removeUserPermanence(User $userPermanence): self
    {
        if ($this->user_permanence->contains($userPermanence)) {
            $this->user_permanence->removeElement($userPermanence);
        }

        return $this;
    }

    /**
     * @return Collection|Echange[]
     */
    public function getEchanges(): Collection
    {
        return $this->echanges;
    }

    public function addEchange(Echange $echange): self
    {
        if (!$this->echanges->contains($echange)) {
            $this->echanges[] = $echange;
            $echange->setPermanence($this);
        }

        return $this;
    }

    public function removeEchange(Echange $echange): self
    {
        if ($this->echanges->contains($echange)) {
            $this->echanges->removeElement($echange);
            // set the owning side to null (unless already changed)
            if ($echange->getPermanence() === $this) {
                $echange->setPermanence(null);
            }
        }

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
}
